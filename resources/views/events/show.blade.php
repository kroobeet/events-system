<x-app-layout>
    <x-page-header title="{{ $event->name }}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session()->has('success-qr'))
                    <div class="px-4 py-3 rounded relative" style="background-color: #1c7430; color: #eaeaea" role="alert">
                        <p><span class="block sm:inline">{{ session()->get('success-qr') }}</span></p>
                    </div>
                    @if(session()->get('comment'))
                        <div class="px-4 py-3 rounded relative bg-gray-500" style="color: #eaeaea" role="alert">
                            <p><span class="block sm:inline">{{ session()->get('comment') }}</span></p>
                            <p><a href="{{ route('events.addComment', [$event->id, session()->get('user')]) }}" style="color: #eaeaea">Редактировать комментарий</a></p>
                        </div>
                    @else
                        <div class="px-4 py-3 rounded relative bg-gray-500" style="color: #eaeaea" role="alert">
                            <p><a href="{{ route('events.addComment', [$event->id, session()->get('user')]) }}" style="color: #eaeaea">Добавить комментарий</a></p>
                        </div>
                    @endif
                @elseif(session()->has('success'))
                    <div class="px-4 py-3 rounded relative" style="background-color: #1c7430; color: #eaeaea" role="alert">
                        <span class="block sm:inline">{{ session()->get('success') }}</span>
                    </div>
                @endif
                @if(session()->has('warning'))
                    <div class="px-4 py-3 rounded relative" style="background-color: #c49121; color: #eaeaea" role="alert">
                        <span class="block sm:inline">{{ session()->get('warning') }}</span>
                    </div>
                @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $event->name }}</h1>
                    @if (Auth::user()->hasAnyRole(['manager', 'employee']))
                        <p class="mb-4">
                            <a href="{{ route('events.scan.qr', $event->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md focus:outline-none">Сканировать QR-код</a>
                        </p>
                    @endif
                    <p class="mb-4"><strong>Начало:</strong> {{ $event->start_time }}</p>
                    <p class="mb-4"><strong>Конец:</strong> {{ $event->end_time }}</p>
                    <p class="mb-4"><strong>Заказчик мероприятия: </strong> <a href="{{ route('organizations.show', $event->organization->id) }}">{{ $event->organization->name }}</a></p>

                    @if (Auth::user()->hasRole('manager'))
                    <h2 class="text-xl font-semibold mt-6 mb-4">Добавьте нового участника, если это необходимо:</h2>
                    <form action="{{ route('events.attachParticipant', ['id' => $event->id]) }}" method="POST">
                        @csrf
                        <!-- Здесь добавьте выпадающий список с пользователями и кнопку "Прикрепить" -->
                        <select name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                        <x-secondary-button type="submit">Прикрепить участника</x-secondary-button>
                    </form>
                    @endif

                    <h2 class="text-xl font-semibold mt-6 mb-4">Участники</h2>
                    <x-search-form action="{{ route('events.show', $event->id) }}" />
                    <x-data-table :items="$participants" :columns="[
                        ['label' => 'ФИО', 'field' => 'full_name', 'route' => 'users.edit'],
                        ['label' => 'E-Mail', 'field' => 'email'],
                        ['label' => 'Комментарий', 'field' => 'comment', 'event' => $event->id],
                        ['label' => 'Дата и время прихода', 'field' => 'participant_came', 'event' => $event->id]
                    ]" :actions="[
                        ['type' => 'link', 'route' => 'users.edit', 'label' => 'Редактировать', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'users.show', 'label' => 'Посмотреть', 'roles' => ['manager']],
                        ['type' => 'link', 'route' => 'events.addComment', 'event' => $event->id, 'label' => 'Добавить комментарий', 'roles' => ['manager', 'employee']],
                        ['type' => 'link',
                        'method' => 'POST',
                        'route' => 'events.detachParticipant',
                        'event' => $event->id,
                        'confirm' => 'Вы уверены, что хотите отвязать этого пользователя от мероприятия?',
                        'label' => 'Открепить участника', 'roles' => ['manager', 'employee']],
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
