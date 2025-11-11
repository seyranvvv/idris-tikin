@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-lg w-full">
        <h2 class="text-2xl font-extrabold text-blue-900 mb-6 tracking-wide">Добавить слайдер</h2>
        
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sliders.store') }}" class="space-y-5" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="link" class="block text-gray-700 font-semibold mb-1">Ссылка (опционально)</label>
                <input type="url" id="link" name="link" value="{{ old('link') }}" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="https://example.com">
            </div>
            <div>
                <label for="image" class="block text-gray-700 font-semibold mb-1">Изображение</label>
                <input type="file" id="image" name="image" accept="image/*" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition">Сохранить</button>
                <a href="{{ route('sliders.index') }}" class="w-full bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-bold text-lg hover:bg-gray-400 transition text-center">Назад</a>
            </div>
        </form>
    </div>
</div>
@endsection