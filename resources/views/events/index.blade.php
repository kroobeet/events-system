<x-app-layout>
    <x-page-header title="Мероприятия" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-session-messages />
                    <h1 class="text-2xl font-semibold mb-4">Список мероприятий</h1>
                    <div class="mb-4 flex justify-end">
                        <x-action-button route="{{ route('events.create') }}" label="Создать мероприятие" color="gray" />
                    </div>
                    <x-search-form action="{{ route('events.index') }}" />
                    <x-data-table :items="$events" :columns="[
                        ['label' => 'Название', 'field' => 'name', 'route' => 'events.show'],
                        ['label' => 'Начало', 'field' => 'start_time'],
                        ['label' => 'Конец', 'field' => 'end_time'],
                        ['label' => 'Заказчик', 'field' => 'organization', 'route' => 'organizations.show']
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'events.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'events.show', 'label' => 'Посмотреть', 'roles' => ['manager', 'employee']],
                        ['type' => 'form', 'route' => 'events.destroy', 'method' => 'DELETE', 'label' => 'Удалить', 'confirm' => 'Вы уверены, что хотите удалить это мероприятие?', 'roles' => ['manager']]
                    ]"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
