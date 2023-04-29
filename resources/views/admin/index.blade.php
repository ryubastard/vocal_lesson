<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理画面
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-center py-2">講師一覧</h2>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        
                        @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif

                        <button onclick="location.href='{{ route('admin.create') }}'" class="flex mb-4 ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規登録</button>
                        
                        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            講師名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            パスワード変更</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers as $teacher)
                                    <tr>
                                        <td class="text-blue-500 px-4 py-3">{{ $teacher->name }}</td>
                                        <td class="px-4 py-3">
                                            <a href="#" class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">
                                                開く
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>