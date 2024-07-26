<x-app-layout>
    <x-page-header title="Заказчики" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-session-messages />
                    <h1 class="text-2xl font-semibold mb-4">Список заказчиков</h1>
                    <div class="mb-4 flex justify-end">
                        <x-action-button route="{{ route('organizations.create') }}" label="Добавить заказчика" color="gray" />
                    </div>
                    <x-search-form action="{{ route('organizations.index') }}" />
                    <x-data-table :items="$organizations" :columns="[
                        ['label' => 'Название', 'field' => 'name', 'route' => 'organizations.show'],
                        ['label' => 'Телефон', 'field' => 'phone'],
                        ['label' => 'Email', 'field' => 'email']
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'organizations.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'organizations.show', 'label' => 'Посмотреть', 'roles' => ['manager']],
                        ['type' => 'form', 'route' => 'organizations.destroy', 'method' => 'DELETE', 'label' => 'Удалить', 'confirm' => 'Вы уверены, что хотите удалить этого заказчика?', 'roles' => ['manager']]
                    ]"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
