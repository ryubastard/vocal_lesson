<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            information管理
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('information.update', ['id' => $information->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="py-4">
            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex flex-col px-5 py-6 justify-center items-center">
                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="w-full md:w-2/3 flex flex-col mb-4 items-start">
                        <b class="sm:text-2xl text-3xl mb-4 font-medium text-gray-900">information画像</b>

                        @for($i = 1; $i <= 3; $i++) 
                        画像{{$i}}
                        <div class="flex items-center">
                            @if ($information["image{$i}"])
                            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-6 object-cover object-center rounded" src="{{ asset('storage/images/' . $information["image{$i}"]) }}" alt="image{{$i}}">
                            @else
                            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-6 object-cover object-center rounded" src="{{ asset('images/no_image.jpg') }}" alt="no image">
                            @endif
                            <div class="ml-4">
                                @if ($information["image{$i}"])
                                <div class="mb-2">
                                    <input type="checkbox" name="delete_image{{$i}}" id="delete_image{{$i}}">
                                    <label for="delete_image{{$i}}" class="ml-2">画像を削除する</label>
                                </div>
                                @endif
                                <div>
                                    <label for="image{{$i}}" class="cursor-pointer inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        <span>新しい画像を添付する</span>
                                        <input id="image{{$i}}" name="image{{$i}}" type="file" accept="image/*" class="sr-only" onchange="document.getElementById('image-label{{$i}}').textContent = this.files[0].name;">
                                    </label>
                                    <span id="image-label{{$i}}" class="ml-2"></span>
                                </div>
                            </div>
                    </div>
                    @endfor
                </div>

                <div class="w-full md:w-2/3 flex flex-col mb-16 items-start">
                    <b class="sm:text-2xl text-3xl mb-4 font-medium text-gray-900">サービス説明</b>
                    <x-textarea rows="6" id="information" name="information" class="block mt-1 w-full" style="width: 92%;">
                        {{ $information->information }}
                    </x-textarea>
                    <div class="flex w-full justify-center items-end">
                        <x-button class="ml-4 my-3">
                            確定する
                        </x-button>
                    </div>
                </div>
        </div>
        </section>
        </div>
    </form>

</x-app-layout>