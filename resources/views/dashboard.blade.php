<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            講師一覧
        </h2>
    </x-slot>

    @if (session('status'))
    <div class="my-4 font-medium text-sm text-green-600 text-center">
        {{ session('status') }}
    </div>
    @endif

    @livewire('teacher')

</x-app-layout>