<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="w-40">
                <img src="{{ asset('images/logo.png') }}">
            </div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            パスワードを忘れた場合は、メールアドレスを教えていただければ、新しいパスワードを選択できるようにパスワードリセットのリンクをメールで送信します。
        </div>

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="メールアドレス" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    メールパスワードリセットリンク
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>