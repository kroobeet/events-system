@props(['action'])

<form action="{{ $action }}" method="GET" class="mb-4">
    <div class="flex items-center">
        <input type="text" name="search" placeholder="Поиск..." class="w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <button type="submit" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">Искать</button>
    </div>
</form>
