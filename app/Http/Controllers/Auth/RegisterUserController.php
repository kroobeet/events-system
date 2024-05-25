<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisterUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $roles = [];
        $organizations = Organization::all();

        if ($request->user()->hasRole('manager')) {
            $roles = Role::whereIn('name', ['manager', 'participant', 'employee'])->get();
        }

        return view('auth.register', compact('roles', 'organizations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'birth_year' => 'nullable|date_format:Y',
            'phone' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization' => ['required', 'exists:organizations,name'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $organization = Organization::where('name', $request->organization)->firstOrFail();

        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_year' => $request->birth_year,
            'phone' => $request->phone,
            'organization_id' => $organization->id,
        ]);

        $user->assignRole($request->role);

        event(new Registered($user));

        return redirect()->route('dashboard')->with('success', 'Пользователь зарегистрирован');
    }
}