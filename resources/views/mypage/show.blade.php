<x-app-layout>
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

                    <form id="cancel_{{ $lesson->id }}" method="POST" action="{{ route('mypage.cancel', ['id' => $lesson->id]) }}">
                        @csrf
                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-label for="max_people" value="予約数" />
                                {{ $reservation->number_of_people }}
                            </div>
                            @if ($lesson->lessonDate == \Carbon\Carbon::today()->format('Y年m月d日'))
                            <span class="text-red-500 text-xs">レッスン当日のためキャンセルできません。</span>
                            @elseif ($lesson->lessonDate < \Carbon\Carbon::today()->format('Y年m月d日'))
                                @else
                                <button onclick="return confirm('本当にキャンセルしてもよろしいですか？')" class="bg-red-500 rounded-md text-white ml-4 py-1 px-2">キャンセル</button>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/flatpickr.js') }}"></script>
</x-app-layout>