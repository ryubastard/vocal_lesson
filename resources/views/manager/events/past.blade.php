<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去のレッスン一覧
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        <button onclick="location.href='{{ route('events.index') }}'"
                            class="flex mb-4 ml-auto text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded">最新レッスン一覧</button>

                        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            レッスン場所</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            日付</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            予約人数</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            定員数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td class="text-blue-500 px-4 py-3"><a
                                                    href="{{ route('events.detail', ['event' => $event->location, 'date' => $event->date]) }}">{{ $event->location }}
                                            </td>
                                            <td class="px-4 py-3">{{ $event->date }}</td>
                                            <td class="px-4 py-3">
                                                @if (is_null($event->reserved_people_sum))
                                                    0
                                                @else
                                                    {{ $event->reserved_people_sum }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">{{ $event->max_people_sum }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $events->links() }}
                            <!̶ ページネーション表示 ̶>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
