@extends('layouts.app')

@section('content')
<div class="w-full min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8 flex justify-center items-center">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-3xl w-full">
        <h2 class="text-2xl font-extrabold text-blue-900 mb-6 tracking-wide">Категории для материала: <span class="text-blue-600">{{ $material->material_name }}</span></h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">{{ session('success') }}</div>
        @endif

        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-2 text-blue-800">Текущие категории:</h3>
            @if($material->custom_categories->count())
                <ul class="bg-blue-50 rounded-lg shadow divide-y divide-blue-200">
                    @foreach($material->custom_categories as $category)
                        <li class="flex items-center justify-between px-4 py-2">
                            <span class="font-medium text-blue-900">{{ $category->name_ru }}</span>
                            <form method="POST" action="{{ route('material-category-links.destroy', ['material_id' => $material->material_id, 'category_id' => $category->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold px-3 py-1 rounded transition bg-red-100 hover:bg-red-200">Удалить</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500">Нет связанных категорий.</div>
            @endif
        </div>

        <div class="bg-blue-50 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-blue-800">Добавить категорию</h3>
            <form method="POST" action="{{ route('material-category-links.store', $material->material_id) }}">
                @csrf
                <div class="flex items-center gap-4">
                    <select name="category_id" class="form-select block w-full rounded border-blue-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            @if(!$material->custom_categories->contains('id', $category->id))
                                <option value="{{ $category->id }}">{{ $category->name_ru }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Добавить</button>
                </div>
            </form>
        </div>
        <!-- Секция изображений материала -->
        <div class="bg-blue-50 rounded-lg shadow p-6 mt-10">
            <h3 class="text-lg font-semibold mb-4 text-blue-800">Изображения материала</h3>
            <!-- Форма загрузки -->
            <form method="POST" action="{{ route('material-images.store', $material->material_id) }}" enctype="multipart/form-data" class="mb-6 flex flex-col sm:flex-row gap-4 items-center">
                @csrf
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full border border-blue-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Загрузить</button>
            </form>

            <!-- Галерея изображений -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($material->images as $image)
                    <div class="relative group bg-white rounded-lg shadow p-2 flex flex-col items-center">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Изображение" class="w-32 h-32 object-cover rounded mb-2 border border-blue-200">
                        <div class="flex gap-2">
                            <!-- Кнопка удалить -->
                            <form method="POST" action="{{ route('material-images.destroy', [$material->material_id, $image->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-xs">Удалить</button>
                            </form>
                            <!-- Кнопка изменить (открывает input) -->
                            <form method="POST" action="{{ route('material-images.update', [$material->material_id, $image->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <label class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition text-xs cursor-pointer">
                                    Изменить
                                    <input type="file" name="image" accept="image/*" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
