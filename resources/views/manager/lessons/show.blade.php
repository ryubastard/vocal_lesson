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

                    <form method="GET" action="{{ route('lessons.edit', ['lesson' => $lesson->id]) }}">

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
                            <div class="flex space-x-4 justify-around">
                                @if ($lesson->is_visible)
                                表示中
                                @else
                                非表示
                                @endif
                            </div>
                            @if ($lesson->lessonDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                            <x-button class="ml-4">
                                編集する
                            </x-button>
                    </form>
                    <form id="destroy_{{ $lesson->id }}" method="POST" action="{{ route('lessons.destroy', ['lesson' => $lesson->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('本当にキャンセルしてもよろしいですか？')" class="bg-red-500 rounded-md text-white ml-4 py-1 px-2">キャンセル</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="pt-4 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">
                    @if (!empty($reservations))
                    <div class="text-center py-2">予約情報</div>
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    予約者名
                                </th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    予約人数
                                </th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                            <form id="cancel_{{ $reservation['id'] }}" method="POST" action="{{ route('lessons.cancel', ['lesson' => $lesson->id, 'id' => $reservation['id']]) }}">
                                @csrf
                                <tr>
                                    <td class="text-blue-500 px-4 py-3">
                                        <a href="mailto:{{ $reservation['email'] }}">{{ $reservation['name'] }}</a>
                                    </td>
                                    <td class="px-4 py-3">{{ $reservation['number_of_people'] }}</td>
                                    <td class="px-4 py-3">
                                        @if ($lesson->lessonDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                                        <button onclick="return confirm('本当にキャンセルしてもよろしいですか？')" class="bg-red-500 rounded-md text-white ml-4 py-1 px-2">キャンセル</button>
                                        @endif
                                    </td>
                                </tr>
                            </form>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/flatpickr.js') }}"></script>
</x-app-layout>