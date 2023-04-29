<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            講師新規登録
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

                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf

                        <div>
                            <x-label for="name" value="講師名" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="kana" value="フリガナ" />
                            <x-input id="kana" class="block mt-1 w-full" type="text" name="kana" :value="old('kana')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="メールアドレス" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="パスワード" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        </div>

                        <div class="mt-4 md:flex justify-between items-end">
                            <div class="flex space-x-4 justify-around">
                                <input type="checkbox" id="registration" name="registration" class="block mt-1" value="1" />
                                続けて登録する
                            </div>
                            <x-button class="ml-4">
                                新規登録
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/flatpickr.js') }}"></script>
</x-app-layout>