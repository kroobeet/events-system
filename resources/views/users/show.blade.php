<x-app-layout>
    <x-page-header title="{{ $user->full_name }}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-session-messages />
                    <h1 class="text-2xl font-semibold mb-4">{{ $user->full_name }}</h1>
                    <p class="mb-4"><strong>Организация: </strong>{{ $user->organization_name ?? 'Не заполнено'}}</p>
                    @if (!empty($organization))
                        <p class="mb-4"><strong>Относится к заказчику: </strong><a href="{{ route('organizations.show', $organization->id) }}">{{ $organization->name }}</a></p>
                    @else
                        <p class="mb-4"><strong>Относится к заказчику: </strong>Нет</p>
                    @endif
                    <p class="mb-4"><strong>Email: </strong>{{ $user->email }}</p>
                    <p class="mb-4"><strong>Год рождения: </strong>{{ $user->birth_year ?? 'Не заполнено'}}</p>
                    <p class="mb-4"><strong>Телефон: </strong>{{ $user->phone ?? 'Не заполнено'}}</p>
                    <p class="mb-4"><strong>Диплом 1: </strong>{{ $user->diploma_1 ?? 'Не заполнено'}}</p>
                    <p class="mb-4"><strong>Диплом 2: </strong>{{ $user->diploma_2 ?? 'Не заполнено'}}</p>
                    <p class="mb-4"><strong>СНИЛС: </strong>{{ $user->snils ?? 'Не заполнено'}}</p>
                    <p class="mb-4"><strong>Кол-во мероприятий: </strong>{{ $user->events->count() ?? 'У пользователя нет мероприятий' }}</p>

                    @if($events->count() > 0)
                        <h2 class="text-xl font-semibold mt-6 mb-4">Мероприятия пользователя</h2>
                        <x-data-table :items="$events" :columns="[
                            ['label' => 'Название', 'field' => 'name'],
                            ['label' => 'Место проведения', 'field' => 'location'],
                        ]" :actions="[
                            ['type' => 'link', 'route' => 'events.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                            ['type' => 'link', 'route' => 'events.show', 'label' => 'Посмотреть', 'roles' => ['manager']],
                        ]"/>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Назад к списку пользователей</a>
                    </div>
                    @if (Auth::user()->hasAnyRole(['manager']))
                        <div class="mt-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Редактировать пользователя</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


