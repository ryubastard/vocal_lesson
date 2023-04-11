<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span style="font-weight: normal;border-bottom: 2px solid black;">登録情報入力</span>＞
            <span style="border-bottom: 2px solid orange;color: orange;">確認</span>＞
            <span style="font-weight: normal;border-bottom: 2px solid black;">完了</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-2xl py-4 mx-auto">

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="mt-4">
                        <x-label for="lesson_name" value="レッスン名" />
                        {{ $lesson->name }}
                    </div>

                    <div class="mt-4">
                        <x-label for="price" value="レッスン料金" />
                        {{ number_format($lesson->price) }}円
                    </div>

                    <div class="mt-4">
                        <x-label for="price" value="レッスン場所" />
                        {{ $lesson->location }}
                    </div>

                    <div class="mt-4">
                        <x-label for="lesson_date" value="レッスン日時" />
                        {{ $lesson->lessonDate }} {{ $lesson->startTime }}～{{ $lesson->endTime }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">

                    <form method="POST" action="{{ route('registration.store', ['id' => $lesson]) }}">
                        @csrf

                        <div>
                            <x-label for="name" value="お名前" />
                            {{ $name }}
                        </div>

                        <div class="mt-4">
                            <x-label for="kana" value="カナ" />
                            {{ $kana }}
                        </div>


                        <div class="mt-4">
                            <x-label for="email" value="メールアドレス" />
                            {{ $email }}
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="パスワード" class="block font-medium text-sm text-gray-700" />
                            セキュリティ上の理由から非表示としています。
                        </div>

                        <input type="hidden" name="id" value="{{ $lesson }}">
                        <div class="flex items-center justify-between mt-4">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-200 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150" onclick="history.back()">
                                戻る
                            </button>
                            <x-button>
                                登録
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>