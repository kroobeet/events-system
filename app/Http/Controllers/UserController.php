<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('last_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('first_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('patronymic', 'like', '%' . $request->input('search') . '%')
                ->orWhere('email', 'like', '%' . $request->input('search') . '%');
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Пользователь удален успешно');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $organizations = Organization::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'organizations', 'roles'));
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $events = $user->events()->paginate(10);
        $organization = $user->organization;
        return view('users.show', compact('user', 'events', 'organization'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'birth_year' => 'nullable|date_format:Y',
            'phone' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'organization' => ['required', 'exists:organizations,name'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $organization = Organization::where('name', $request->organization)->firstOrFail();

        $user->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'birth_year' => $request->birth_year,
            'phone' => $request->phone,
            'organization_id' => $organization->id,
        ]);

        // Обновление роли пользователя, если она изменилась
        $user->syncRoles($request->role);

        return redirect()->route('dashboard')->with('success', 'Информация о пользователе обновлена');
    }
}