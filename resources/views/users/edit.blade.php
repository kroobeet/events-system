<x-guest-layout>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="last_name" :value="__('Фамилия')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="first_name" :value="__('Имя')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="patronymic" :value="__('Отчество')" />
            <x-text-input id="patronymic" class="block mt-1 w-full" type="text" name="patronymic" :value="old('patronymic', $user->patronymic)" autofocus autocomplete="patronymic" />
            <x-input-error :messages="$errors->get('patronymic')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="birth_year" :value="__('Год рождения')" />
            <x-text-input id="birth_year" class="block mt-1 w-full" type="text" name="birth_year" :value="old('birth_year', $user->birth_year)" autofocus autocomplete="birth_year" />
            <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Телефон')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone', $user->phone)" autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="organization" :value="__('Организация')" />
            <select name="organization" id="organization" class="block mt-1 w-full" required>
                @foreach($organizations as $organization)
                    @if (!empty($user->organization))
                        <option value="{{ $organization->name }}" @if($organization->name == $user->organization->name) selected @endif>{{ $organization->name }}</option>
                    @else
                        <option value="{{ $organization->name }}">{{ $organization->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль (оставьте пустым для сохранения текущего)')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Повторите пароль (оставьте пустым для сохранения текущего)')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Роль пользователя')" />
            <select name="role" id="role" class="block mt-1 w-full" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" @if($role->name == $user->roles->first()->name) selected @endif>{{ $role->comment }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Обновить') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
