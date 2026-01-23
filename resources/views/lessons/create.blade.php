@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Создание урока</h1>

    <form action="{{ route('lessons.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Название урока -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Название урока</label>
            <input type="text" name="title" required
                placeholder="Введите название урока"
                class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg">
        </div>

        <!-- Описание урока с TinyMCE -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Описание урока</label>
            <textarea id="description" name="description"
                class="w-full h-64 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"></textarea>
        </div>

        <!-- Видео -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Ссылка на видео</label>
            <input type="url" name="video_url"
                placeholder="https://youtube.com..."
                class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg">
        </div>

        <!-- Курс и Категория -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-lg">Курс</label>
                <select name="course_id" required
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-lg">Категория</label>
                <select name="category_id" required
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition text-lg">
            Создать урок
        </button>
    </form>
</div>

<!-- TinyMCE -->

<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
  selector: '#description',
  height: 300,
  width: '100%',
  menubar: true,
  plugins: [
    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
    'searchreplace', 'visualblocks', 'code', 'fullscreen',
    'insertdatetime', 'media', 'table', 'help', 'wordcount'
  ],
  toolbar: 'undo redo | formatselect | bold italic underline strikethrough | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help | \
            charmap | link image media | forecolor backcolor',
  content_style: "body { font-family:Arial,sans-serif; font-size:16px }"
});

</script>
@endsection
