<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レッスン詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">
                    <div style="text-align: center;">
                        <p class="my-4">ログインすると簡単に予約ができます</p>
                        <div class="flex items-center justify-center mt-4">
                            <x-button class="my-4 bg-blue-300 text-white hover:bg-blue-500" onclick="location.href='{{ route('login') }}'">
                                ログイン
                            </x-button>
                        </div>
                        <div class="flex items-center justify-center mt-4">

                            <input type="hidden" name="id" value="{{ $id }}">
                            <x-button class="my-4 bg-black-300 border border-black text-black hover:bg-gray-500" onclick="location.href='{{ route('lessons.store', ['id' => $id]) }}'">
                                初めての方はこちらから
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>