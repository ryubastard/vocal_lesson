<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span style="border-bottom: 2px solid orange;color: orange;">登録情報入力</span>＞
            <span style="font-weight: normal;border-bottom: 2px solid black;">確認</span>＞
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
                        <span class="text-blue-500 cursor-pointer ml-2" onclick="location.href='/'">選びなおす</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">

                    <form method="POST" action="{{ route('register.verification', ['id' => $lesson]) }}">
                        @csrf

                        <div>
                            <x-label for="name" value="お名前" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="kana" value="カナ" />
                            <x-input id="kana" class="block mt-1 w-full" type="text" name="kana" :value="old('kana')" required autofocus autocomplete="kana" />
                        </div>


                        <div class="mt-4">
                            <x-label for="email" value="メールアドレス" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="パスワード" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="パスワード確認用" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                入力内容を確認する
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>