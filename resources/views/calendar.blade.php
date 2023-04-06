<x-calendar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レッスンカレンダー
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="lesson-calendar mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('calendar')
            </div>
        </div>
    </div>
</x-calendar-layout>
