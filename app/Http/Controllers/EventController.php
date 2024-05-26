<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $query = Event::query();

        // Поиск по названию мероприятия
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('start_time', 'like', '%' . $searchTerm . '%')
                ->orWhere('end_time', 'like', '%' . $searchTerm . '%');
        }

        $events = $query->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $organizations = Organization::all();
        return view('events.edit', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'organization_id' => 'required|exists:organizations,id',
            'departament' => 'nullable',
            'location' => 'required|string|max:255',
        ]);

        Event::create([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'organization_id' => $request->organization_id,
            'departament' => $request->departament,
            'location' => $request->location
        ]);

        return redirect()->route('events.index')->with('success', 'Мероприятие успешно создано.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $event = Event::findOrFail($id);

        // Получите роль "participant"
        $participantRole = Role::where('name', 'participant')->first();

        // Получите всех пользователей с ролью "participant", которые еще не участвуют в этом мероприятии
        $users = $participantRole->users()->whereDoesntHave('events', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();

        // Пагинация на 10 участников на страницу
        $participants = $event->participants()->paginate(10);

        return view('events.show', compact('event', 'participants', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $event = Event::findOrFail($id);
        $organizations = Organization::all();
        return view('events.edit', compact('event', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'organization_id' => 'required|exists:organizations,id',
            'departament' => 'nullable',
            'location' => 'required|string|max:255',
        ]);

        $event->update($request->all());

        return redirect()->route('events.show', $event)->with('success', 'Мероприятие обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Мероприятие успешно удалено');
    }

    public function attachParticipant(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $participant = User::findOrFail($request->get('user_id'));

        // Проверьте, не принадлежит ли участник уже к этому событию
        if ($event->participants->contains($participant)) {
            return redirect()->route('events.show', $id)->with('error', 'Участник уже привязан к мероприятию.');
        }

        // Привяжите участника к мероприятию
        $event->participants()->attach($participant);

        return redirect()->route('events.show', $id)->with('success', 'Участник успешно добавлен к мероприятию.');
    }

    public function addComment($id, $participant_id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $event = Event::findOrFail($id);
        $participant = User::findOrFail($participant_id);
        $comment = $participant->comment($event->id);
        return view('events.add-comment', compact('event', 'participant', 'comment'));
    }

    public function commentStore(Request $request, $id, $participant_id): RedirectResponse
    {

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $event = Event::findOrFail($id);

        // Проверяем, принадлежит ли указанный пользователь к указанному событию
        if (!$event->participants()->where('user_id', $participant_id)->exists()) {
            return redirect()->back()->with('error', 'Указанный пользователь не является участником этого события.');
        }

        // Находим запись о участнике в событии и обновляем комментарий
        $participant = User::findOrFail($participant_id);
        $comment = $request->input('comment');
        $event->participants()->updateExistingPivot($participant->id, ['comment' => $comment]);

        return redirect()->route('events.show', $id)->with('success', 'Комментарий успешно добавлен.');
    }

    public function qrScanner($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('events.scan-qr', compact('event'));
    }

    public function qrValidate($event_id, $qr_code)
    {
        // Находим мероприятие по идентификатору
        $event = Event::findOrFail($event_id);

        // Находим пользователя по QR-коду
        $user = User::where('qr_code', $qr_code)->first();

        // Проверяем, найден ли пользователь
        if (!$user) {
            return redirect()->route('events.show', $event_id)->with('warning', 'Пользователь с таким QR-кодом не найден');
        }

        // Проверяем, является ли пользователь участником мероприятия
        $participant = $event->participants()->where('user_id', $user->id)->first();

        if ($participant) {
            // Проверяем поле participant_came
            $eventParticipant = DB::table('event_participant')
                ->where('event_id', $event_id)
                ->where('user_id', $user->id)
                ->first();

            if (is_null($eventParticipant->participant_came)) {
                // Обновляем поле participant_came текущим временем
                DB::table('event_participant')
                    ->where('event_id', $event_id)
                    ->where('user_id', $user->id)
                    ->update(['participant_came' => now()]);
            }

            return redirect()->route('events.show', $event_id)
                ->with('success', 'Пользователь '.$user->full_name.' является участником данного мероприятия');
        } else {
            return redirect()->route('events.show', $event_id)
                ->with('warning', 'Пользователь '.$user->full_name.' не является участником данного мероприятия');
        }
    }


}
