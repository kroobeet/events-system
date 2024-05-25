<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $event = Event::findOrFail($id);
        $participants = $event->participants()->paginate(10); // Пагинация на 10 участников на страницу
        return view('events.show', compact('event', 'participants'));
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

    public function setParticipant(string $id, $participant_id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $participant = User::findOrFail($participant_id);
        $event->participants()->attach($participant);
        return redirect()->route('events.show', $id)->with('success', 'Участник'. $participant->full_name .'успешно добавлен');
    }
}
