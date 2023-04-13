<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            information管理
        </h2>
    </x-slot>

    <div class="py-4">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex flex-col px-5 py-6 justify-center items-center">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                
                <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero"
                    src="{{ asset('images/no_image.jpg') }}">
                <div class="w-full md:w-2/3 flex flex-col mb-16 items-start">
                    <b class="sm:text-2xl text-3xl mb-4 font-medium text-gray-900">サービス説明</b>
                    <p class="mb-8 leading-relaxed text-lg">{!! nl2br(e($information->information)) !!}</p>
                    <div class="flex w-full justify-center items-end">
                        <form method="GET" action="{{ route('information.edit') }}">
                            <x-button class="ml-4 my-3">
                                編集する
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-app-layout>
