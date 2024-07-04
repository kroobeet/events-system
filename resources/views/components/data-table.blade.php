@props(['items', 'columns', 'actions' => []])

<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
        <tr>
            @foreach ($columns as $column)
                <th class="w-1/{{ count($columns) }} text-left py-3 px-4 uppercase font-semibold text-sm">{{ $column['label'] }}</th>
            @endforeach
            @if ($actions)
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Действия</th>
            @endif
        </tr>
        </thead>
        <tbody class="text-gray-700">
        @foreach ($items as $item)
            <tr>
                @foreach ($columns as $column)
                    <td class="w-1/{{ count($columns) }} text-left py-3 px-4">
                        @if ($column['field'] === 'organization')
                            @if (isset($column['route']))
                                <a href="{{ route($column['route'], $item->organization->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $item->organization->name }}
                                </a>
                            @else
                                {{ $item->organization->name }}
                            @endif
                        @elseif($column['field'] === 'comment')
                            {{ $item->comment($column['event']) }}
                        @else
                            @if (isset($column['route']))
                                <a href="{{ route($column['route'], $item->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $item->{$column['field']} }}
                                </a>
                            @else
                                {{ $item->{$column['field']} }}
                            @endif
                        @endif
                        @if($column['field'] === 'participant_came')
                            {{ $item->participantСame($column['event']) }}
                        @endif
                    </td>
                @endforeach
                    @if ($actions)
                        <td class="text-left py-3 px-4">
                            @foreach ($actions as $action)
                                @if (empty($action['roles']) || Auth::user()->hasAnyRole($action['roles']))
                                    @if ($action['type'] === 'link')
                                        @if ($action['route'] === 'organizations.representatives.edit')
                                            <a href="{{ route($action['route'], ['organization' => $item->organization->id, 'representative' => $item->id]) }}" class="text-blue-600 hover:text-blue-900">{{ $action['label'] }}</a>
                                        @elseif($action['route'] === 'events.addComment')
                                            <a href="{{ route($action['route'], ['id' => $action['event'], 'participant_id' => $item->id]) }}" class="text-blue-600 hover:text-blue-900">{{ $action['label'] }}</a>
                                        @else
                                            <a href="{{ route($action['route'], $item->id) }}" class="text-blue-600 hover:text-blue-900">{{ $action['label'] }}</a>
                                        @endif
                                    @elseif ($action['type'] === 'form')
                                        <form action="{{ route($action['route'], $item->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method($action['method'])
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('{{ $action['confirm'] }}')">{{ $action['label'] }}</button>
                                        </form>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- Пагинация -->
<div class="mt-4">
    {{ $items->links() }}
</div>
