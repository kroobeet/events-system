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
            $roles = Role::whereIn('name', ['manager', 'participant', 'employee'])->orderByRaw('id desc')->get();
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
            'patronymic' => ['nullable', 'string', 'max:255'],
            'diploma_1' => ['nullable', 'string', 'max:255'],
            'diploma_2' => ['nullable', 'string', 'max:255'],
            'snils' => ['nullable', 'regex:/^\+?[0-9]{11}$/'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'birth_year' => 'nullable|date_format:Y',
            'phone' => ['nullable', 'regex:/^\+?[0-9\s\-()]{10,20}$/'],
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
            'diploma_1' => $request->diploma_1,
            'diploma_2' => $request->diploma_2,
            'snils' => $request->snils,
            'organization_name' => $request->organization_name,
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
