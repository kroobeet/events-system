<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Добавить представителя для {{ $organization->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('organizations.representatives.store', $organization) }}">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="last_name" :value="__('Фамилия')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                        </div>
                        <div>
                            <x-input-label for="first_name" :value="__('Имя')" />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="patronymic" :value="__('Отчество')" />
                            <x-text-input id="patronymic" class="block mt-1 w-full" type="text" name="patronymic" :value="old('patronymic')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="departament" :value="__('Отдел')" />
                            <x-text-input id="departament" class="block mt-1 w-full" type="text" name="departament" :value="old('departament')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Телефон')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                        </div>
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Создать') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>