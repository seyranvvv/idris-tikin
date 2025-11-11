@extends('layouts.app')

@section('content')
<div class="w-full p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Редактировать категорию</h1>
    <form action="{{ route('product-categories.update', $category) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="name_tm" class="block font-medium mb-1">Название (TM)</label>
            <input type="text" id="name_tm" name="name_tm" value="{{ $category->name_tm }}" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label for="name_ru" class="block font-medium mb-1">Название (RU)</label>
            <input type="text" id="name_ru" name="name_ru" value="{{ $category->name_ru }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label for="name_en" class="block font-medium mb-1">Название (EN)</label>
            <input type="text" id="name_en" name="name_en" value="{{ $category->name_en }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label for="image" class="block font-medium mb-1">Изображение</label>
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="image" class="h-16 w-16 object-cover rounded-lg border mb-2" />
            @endif
            <input type="file" id="image" name="image" accept="image/*" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Сохранить</button>
            <a href="{{ route('product-categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Назад</a>
        </div>
    </form>
</div>
@endsection
