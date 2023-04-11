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
                        <p class="my-4">予約にはログインが必要です</p>
                        <div class="flex items-center justify-center mt-4">
                            <button onclick="location.href='{{ route('login') }}'"
                                class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">ログイン</button>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <input type="hidden" name="reserved_people" value="{{ $reserved_people }}">
                            <button
                                onclick="location.href='{{ route('registration.store', ['id' => $id, 'id2' => $reserved_people]) }}'"
                                class="bg-black text-white py-2 px-6 rounded-full">初めての方はこちらから</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
