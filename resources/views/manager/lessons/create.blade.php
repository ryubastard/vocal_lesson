<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レッスン新規登録
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

                    <form method="POST" action="{{ route('lessons.store') }}">
                        @csrf

                        <div>
                            <x-label for="lesson_name" value="レッスン名" />
                            <x-input id="lesson_name" class="block mt-1 w-full" type="text" name="lesson_name"
                                :value="old('lesson_name')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="price" value="レッスン料金" />
                            <x-price id="price" class="block mt-1 w-full" name="price" :value="old('price')">
                            </x-price>
                        </div>

                        <div class="mt-4">
                            <x-label for="location" value="レッスン場所" />
                            <x-input id="location" class="block mt-1 w-full" type="text" name="location"
                                :value="old('location')" required />
                        </div>

                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-label for="lesson_date" value="レッスン日付" />
                                <x-input id="lesson_date" class="block mt-1 w-full" type="text" name="lesson_date"
                                    :value="old('lesson_date')" required />
                            </div>

                            <div class="mt-4">
                                <x-label for="start_time" value="開始時間" />
                                <x-input id="start_time" class="block mt-1 w-full" type="text" name="start_time"
                                    :value="old('start_time')" required />
                            </div>

                            <div class="mt-4">
                                <x-label for="end_time" value="終了時間" />
                                <x-input id="end_time" class="block mt-1 w-full" type="text" name="end_time"
                                    :value="old('end_time')" required />
                            </div>
                        </div>

                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-label for="max_people" value="定員数" />
                                <x-input id="max_people" class="block mt-1 w-full" type="text" name="max_people"
                                    :value="old('max_people')" required />
                            </div>
                            <div class="mt-4">

                            </div>
                            <div class="flex space-x-4 justify-around">
                                <input type="checkbox" id="registration" name="registration" class="block mt-1"
                                    value="1" />
                                続けて登録する
                                <input type="radio" name="is_visible" value="0" checked />表示
                                <input type="radio" name="is_visible" value="1" />非表示
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
