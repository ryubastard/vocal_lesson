<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            マイページ
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-center py-2">最新のレッスン一覧</h2>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!empty($fromTodayLessons))
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                レッスン名</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                レッスン場所</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                開始日時</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                終了日時</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                予約人数</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fromTodayLessons as $lesson)
                                            <tr>
                                                <td class="text-blue-500 px-4 py-3"><a
                                                        href="{{ route('mypage.show', ['id' => $lesson['id']]) }}">{{ $lesson['name'] }}
                                                </td>
                                                <td class="px-4 py-3">{{ $lesson['location'] }}</td>
                                                <td class="px-4 py-3">{{ $lesson['start_date'] }}</td>
                                                <td class="px-4 py-3">{{ $lesson['end_date'] }}</td>
                                                <td class="px-4 py-3">
                                                    {{ $lesson['number_of_people'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>最新のレッスンがありません。</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-center py-2">過去のレッスン一覧</h2>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!empty($pastLessons))
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                レッスン名</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                レッスン場所</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                開始日時</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                終了日時</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                予約人数</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pastLessons as $lesson)
                                            <tr>
                                                <td class="text-blue-500 px-4 py-3"><a
                                                        href="{{ route('mypage.show', ['id' => $lesson['id']]) }}">{{ $lesson['name'] }}
                                                </td>
                                                <td class="px-4 py-3">{{ $lesson['location'] }}</td>
                                                <td class="px-4 py-3">{{ $lesson['start_date'] }}</td>
                                                <td class="px-4 py-3">{{ $lesson['end_date'] }}</td>
                                                <td class="px-4 py-3">
                                                    {{ $lesson['number_of_people'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>過去に受講したレッスンがありません。</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
