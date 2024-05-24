<x-app-layout>
    <x-page-header title="{{ $organization->name }}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $organization->name }}</h1>
                    <p class="mb-4"><strong>Юр.адрес:</strong> {{ $organization->legal_address }}</p>
                    <p class="mb-4"><strong>Email:</strong> {{ $organization->email }}</p>
                    <p class="mb-4"><strong>Кол-во мероприятий:</strong> {{ $organization->events->count() }}</p>

                    <h2 class="text-xl font-semibold mt-6 mb-4">Представители</h2>
                    <div class="mb-4 flex justify-start">
                        <x-action-button route="{{ route('organizations.representatives.create', $organization) }}" label="Добавить представителя" color="gray" />
                    </div>
                    <x-data-table :items="$representatives" :columns="[
                        ['label' => 'ФИО', 'field' => 'full_name'],
                        ['label' => 'Телефон', 'field' => 'phone'],
                        ['label' => 'Отдел', 'field' => 'departament'],
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'organizations.representatives.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                    ]"/>

                    <h2 class="text-xl font-semibold mt-6 mb-4">Мероприятия</h2>
                    <x-data-table :items="$events" :columns="[
                        ['label' => 'Название', 'field' => 'name'],
                        ['label' => 'Место проведения', 'field' => 'location'],
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'events.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'events.show', 'label' => 'Посмотреть', 'roles' => ['manager']],
                    ]"/>

                    <div class="mt-4">
                        <a href="{{ route('organizations.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Назад к списку организаций</a>
                    </div>
                    @if (Auth::user()->hasAnyRole(['manager']))
                        <div class="mt-4">
                            <a href="{{ route('organizations.edit', $organization->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Редактировать организацию</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


