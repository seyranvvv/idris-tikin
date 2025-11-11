@extends('layouts.app')

@section('content')
<div class="w-full min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-6xl mx-auto">
        <h2 class="text-3xl font-extrabold text-blue-900 mb-8 tracking-wide">Материалы</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden shadow">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Код</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Изображения</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">Категории</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-blue-800 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($materials as $material)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $material->material_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $material->material_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $material->material_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-middle">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($material->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="img" class="w-12 h-12 object-cover rounded border border-blue-200">
                                    @endforeach
                                    @if($material->images->isEmpty())
                                        <span class="text-gray-400">Нет</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-middle">
                                @if($material->custom_categories->count())
                                    <ul class="list-disc list-inside text-gray-800 text-sm mb-0">
                                        @foreach($material->custom_categories as $category)
                                            <li>{{ $category->name_ru }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400">Нет категорий</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <a href="{{ route('material-category-links.edit', $material->material_id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow" aria-label="Категории">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-center">
            {{ $materials->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
