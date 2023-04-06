<x-calendar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レッスン詳細
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

                    <form method="GET" action="{{ route('login') }}">

                        <div>
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

                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-label for="lesson_date" value="レッスン日付" />
                                {{ $lesson->lessonDate }}
                            </div>

                            <div class="mt-4">
                                <x-label for="start_time" value="開始時間" />
                                {{ $lesson->startTime }}
                            </div>

                            <div class="mt-4">
                                <x-label for="end_time" value="終了時間" />
                                {{ $lesson->endTime }}
                            </div>
                        </div>

                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-label for="max_people" value="定員数" />
                                {{ $lesson->max_people }}
                            </div>
                            <div class="mt-4">
                                @if ($lesson->lessonDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                                    @if ($resevablePeople <= 0) <span
                                            class="text-red-500 text-xs">
                                            このレッスンは満員です。
                                        </span>
                                    @else
                                        <x-label for="reserved_people" value="予約人数" />
                                        <select name="reserved_people">
                                            @for ($i = 1; $i <= $resevablePeople; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    @endif
                            </div>
                            <input type="hidden" name="id" value="{{ $lesson->id }}">
                            @if ($resevablePeople > 0)
                                @if ($isReserved === null)
                                    <input type="hidden" name="id" value="{{ $lesson->id }}">
                                    <div class="flex items-center justify-center mt-4">
                                        <x-button class="ml-4">
                                            予約する
                                        </x-button>
                                    </div>
                                @else
                                    <span class="text-red-500 text-xs">このレッスンは既に予約済みです。</span>
                                @endif
                            @endif
                        @else
                            <span class="text-red-500 text-xs">このレッスンは終了しました。</span>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x--layout>
