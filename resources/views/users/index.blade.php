<x-app-layout>
    <x-page-header title="Пользователи" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Список пользователей</h1>
                    <div class="mb-4 flex justify-end">
                        <x-action-button route="{{ route('user-register') }}" label="Добавить пользователя" color="gray" />
                    </div>
                    <x-search-form action="{{ route('users.index') }}" />
                    <x-data-table :items="$users" :columns="[
                        ['label' => 'ФИО', 'field' => 'full_name', 'route' => 'users.show'],
                        ['label' => 'Email', 'field' => 'email'],
                        ['label' => 'Телефон', 'field' => 'phone'],
                        ['label' => 'Год рождения', 'field' => 'birth_year'],
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'users.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'users.show', 'label' => 'Посмотреть', 'roles' => ['manager']],
                        ['type' => 'form', 'route' => 'users.destroy', 'method' => 'DELETE', 'label' => 'Удалить', 'confirm' => 'Вы уверены, что хотите удалить этого пользователя?', 'roles' => ['manager']]
                    ]" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
