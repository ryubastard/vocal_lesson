<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            information
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-col items-center">

                <div class="w-full max-w-md mt-2">
                    <img src="{{ asset('images/no_image.jpg') }}" class="w-full">
                </div>

                <div class="my-3">
                    <b>サービス説明</b>

                    <p class="ml-1 my-4">{!! nl2br(e($information->information)) !!}</p>
                </div>

                <div class="flex items-center justify-center my-4">
                    <a href="/calendar"
                        class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">予約できる日を探す</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
