@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-lg w-full">
        <h2 class="text-2xl font-extrabold text-blue-900 mb-6 tracking-wide">Добавить категорию</h2>
        <form method="POST" action="{{ route('product-categories.store') }}" class="space-y-5" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name_tm" class="block text-gray-700 font-semibold mb-1">Название (TM)</label>
                <input type="text" id="name_tm" name="name_tm" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="name_ru" class="block text-gray-700 font-semibold mb-1">Название (RU)</label>
                <input type="text" id="name_ru" name="name_ru" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="name_en" class="block text-gray-700 font-semibold mb-1">Название (EN)</label>
                <input type="text" id="name_en" name="name_en" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="image" class="block text-gray-700 font-semibold mb-1">Изображение</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition">Сохранить</button>
        </form>
    </div>
</div>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Сохранить</button>
            <a href="{{ route('product-categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Назад</a>
        </div>
    </form>
</div>
@endsection
