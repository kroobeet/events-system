<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Главная страница
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-session-messages />
                <div class="p-6 text-gray-900">
                    Добро пожаловать, {{ Auth::user()->full_name }}!
                </div>
                <div class="p-6">
                    <span>Ваш персональный QR-код</span>
                    <img src="{{ $qrCodeImage }}" alt="User QR Code">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
