<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать мероприятие: {{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('events.update', $event->id) }}">
                        @csrf
                        @method('POST')
                        <div>
                            <x-input-label for="name" :value="__('Название')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $event->name }}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="start_time" :value="__('Начало')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" value="{{ $event->start_time }}" required />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="end_time" :value="__('Конец')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" value="{{ $event->end_time }}" required />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="organization_id" :value="__('Организация')" />
                            <select id="organization_id" name="organization_id" class="block mt-1 w-full" required>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ $event->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="departament" :value="__('Отдел заказавший мероприятие')" />
                            <x-text-input id="departament" class="block mt-1 w-full" type="text" name="departament" value="{{ $event->departament }}" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Локация')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ $event->location }}" required />
                        </div>
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Обновить') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
