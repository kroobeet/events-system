<x-app-layout>
    <x-page-header title="{{ $event->name }}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $event->name }}</h1>
                    <p class="mb-4"><strong>Начало:</strong> {{ $event->start_time }}</p>
                    <p class="mb-4"><strong>Конец:</strong> {{ $event->end_time }}</p>
                    <p class="mb-4"><strong>Место проведения: </strong> {{ $event->location }}</p>
                    <p class="mb-4"><strong>Организация заказвшая мероприятие: </strong> <a href="{{ route('organizations.show', $event->organization->id) }}">{{ $event->organization->name }}</a></p>
                    <p class="mb-4"><strong>Отдел заказавший мероприятие</strong> {{ $event->departament ?? 'Отдел отсутствует' }}</p>

                    <h2 class="text-xl font-semibold mt-6 mb-4">Участники</h2>
                    <x-data-table :items="$participants" :columns="[
                        ['label' => 'ФИО', 'field' => 'full_name', 'route' => 'users.edit'],
                        ['label' => 'E-Mail', 'field' => 'email'],
                        ['label' => 'Дата и время прихода', 'field' => 'participant_came']
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'users.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'users.show', 'label' => 'Посмотреть', 'roles' => ['manager']]
                    ]"/>
                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Назад к списку мероприятий</a>
                    </div>
                    @if (Auth::user()->hasAnyRole(['manager']))
                        <div class="mt-4">
                            <a href="{{ route('events.edit', $event->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Редактировать</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>