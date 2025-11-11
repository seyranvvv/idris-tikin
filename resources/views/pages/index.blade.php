@extends('layouts.app')

@section('content')
<div class="w-full min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h2 class="text-3xl font-extrabold text-blue-900 tracking-wide">Страницы</h2>
            <a href="{{ route('pages.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition shadow-md">Добавить страницу</a>
        </div>
        
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden shadow">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Заголовок</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Опубликовано</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-blue-800 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pages as $page)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $page->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $page->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $page->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($page->is_published)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Да</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Нет</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('pages.edit', $page->id) }}" class="inline-block px-4 py-2 bg-yellow-400 text-white rounded-lg font-semibold hover:bg-yellow-500 transition mr-2 shadow">Редактировать</a>
                                <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition shadow" onclick="return confirm('Удалить страницу?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection