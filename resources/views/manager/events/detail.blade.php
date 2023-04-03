<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レッスン概要
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-2xl py-4 mx-auto">

                    <x-validation-errors class="mb-4" />

                    <div class="mt-4">
                        <x-label for="price" value="レッスン場所" />
                        {{ $events[0]->location }}
                    </div>

                    <div class="mt-4">
                        <x-label for="event_date" value="レッスン日付" />
                        {{ $events[0]->eventDate }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-2xl py-4 mx-auto">
                    <div class="text-center py-2">レッスン情報</div>
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    レッスン名</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    開始時間</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    終了時間</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    予約人数</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    定員数</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    表示・非表示</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                            <tr>
                                <td class="text-blue-500 px-4 py-3"><a href="{{ route('events.show',['event' => $event->id ]) }}">{{ $event->name }}</a></td>
                                <td class="px-4 py-3">{{ $event->startDate }}</td>
                                <td class="px-4 py-3">{{ $event->endDate }}</td>
                                <td class="px-4 py-3">
                                    @if(is_null($event->number_of_people))
                                    0
                                    @else
                                    {{ $event->number_of_people }}
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                                <td class="px-4 py-3">{{ $event->is_visible == 1 ? '表示' : '非表示' }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ mix('js/flatpickr.js') }}"></script>
</x-app-layout>