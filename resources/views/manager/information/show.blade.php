<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            information管理
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-col items-center">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif

                <div class="w-full max-w-md mt-2">
                    <img src="{{ asset('images/no_image.jpg') }}" class="w-full">
                </div>

                <div class="my-3">
                    <b>サービス説明</b>
                    <p class="ml-1 my-4">{!! nl2br(e($information->information)) !!}</p>
                </div>

                <form method="GET" action="{{ route('information.edit') }}">
                    <x-button class="ml-4 my-3">
                        編集する
                    </x-button>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>