<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Мероприятие: {{ $event->name }}</span><br>
            <span>Добавить комментарий для {{ $participant->full_name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('events.addedCommentStore', [$event->id, $participant->id]) }}">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="comment" :value="__('Комментарий')" />
                            <input id="comment" class="block mt-1 w-full" type="text" name="comment" value="{{ $comment }}" autofocus />
                        </div>
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Добавить комментарий') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
