@props(['route', 'label', 'color' => 'gray'])

<a href="{{ $route }}" class="px-4 py-2 bg-{{ $color }}-500 text-white rounded-md focus:outline-none hover:bg-{{ $color }}-400">
    {{ $label }}
</a>
