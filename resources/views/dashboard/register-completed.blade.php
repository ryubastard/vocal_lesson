<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span style="font-weight: normal;border-bottom: 2px solid black;">登録情報入力</span>＞
            <span style="font-weight: normal;border-bottom: 2px solid black;">確認</span>＞
            <span style="border-bottom: 2px solid orange;color: orange;">完了</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">
                    <div style="text-align: center;">
                        <p class="my-4">ご予約＆登録完了しました。</p>
                        ログイン後、マイページより予約内容の確認ができます。
                        <div class="flex items-center justify-center mt-4">
                            <button onclick="location.href='{{ route('login') }}'" class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">ログイン</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>