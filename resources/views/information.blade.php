<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            information
        </h2>
    </x-slot>

    <div class="py-4">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex flex-col px-5 py-6 justify-center items-center">
                @if ($information->image)
                <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero" src="{{ asset('storage/images/' . $information->image) }}">
                @else
                <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="no image" src="{{ asset('images/no_image.jpg') }}">
                @endif
                <div class="w-full md:w-2/3 flex flex-col mb-16 items-start">
                    <b class="sm:text-2xl text-3xl mb-4 font-medium text-gray-900">サービス説明</b>
                    <p class="mb-8 leading-relaxed text-lg">{!! nl2br(e($information->information)) !!}</p>
                    <div class="flex w-full justify-center items-end">
                        <a href="/calendar" class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">予約できる日を探す</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>