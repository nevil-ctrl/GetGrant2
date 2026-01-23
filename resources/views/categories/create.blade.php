@extends('layouts.app', ['title' => 'Создание категории'])

@section('content')
<div class="container-custom py-10">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-border/60 shadow-sm p-8">
        <h1 class="text-3xl font-bold text-[#1A1A1A] mb-6">Создание категории</h1>

        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Название категории</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name') }}"
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Описание</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-gray-300 text-[#1055b2] focus:ring-[#1055b2]">
                    <span class="ml-2 text-sm text-gray-700">Активна</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-2.5 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors font-semibold">
                    Создать категорию
                </button>
                <a href="{{ route('dashboard') }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
