@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-200 py-8">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 max-w-4xl w-full">
        <h2 class="text-2xl font-extrabold text-blue-900 mb-6 tracking-wide">Редактировать страницу</h2>
        
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pages.update', $page->id) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-1">Заголовок</label>
                <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="slug" class="block text-gray-700 font-semibold mb-1">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="content" class="block text-gray-700 font-semibold mb-1">Контент</label>
                <div id="editor" style="height: 300px; background: white;"></div>
                <textarea id="content" name="content" class="hidden">{{ old('content', $page->content) }}</textarea>
            </div>
            <div>
                <label for="meta_title" class="block text-gray-700 font-semibold mb-1">Meta заголовок (опционально)</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="meta_description" class="block text-gray-700 font-semibold mb-1">Meta описание (опционально)</label>
                <textarea id="meta_description" name="meta_description" rows="3" class="w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_published" class="ml-2 text-gray-700 font-semibold">Опубликовано</label>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition">Сохранить</button>
                <a href="{{ route('pages.index') }}" class="w-full bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-bold text-lg hover:bg-gray-400 transition text-center">Назад</a>
            </div>
        </form>
    </div>
</div>

<!-- Include Quill stylesheet -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Include Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Load initial content if exists
        var initialContent = document.querySelector('#content').value;
        if(initialContent) {
            quill.root.innerHTML = initialContent;
        }

        // Update hidden textarea on every change
        quill.on('text-change', function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        });

        // Also update on form submit as fallback
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelector('#content').value = quill.root.innerHTML;
        });
    });
</script>
@endsection