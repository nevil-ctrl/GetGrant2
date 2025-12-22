<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | GetGrant</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite([
        'resources/css/app.css',
        'resources/js/widgets.tsx',
    ])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <!-- Заголовок -->
        <div class="text-center mb-6">
            <p class="text-sm uppercase tracking-wide text-gray-400">Присоединиться</p>
            <h1 class="text-2xl font-bold text-gray-900">Создать аккаунт</h1>
        </div>

        <!-- Форма -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Имя -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

<div class="relative">
    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Телефон</label>
    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500"
        placeholder="(700) 12-34-56">
    <p id="phone-error" class="mt-1 text-sm text-red-500"></p>
</div>


            <!-- Тип профиля -->
            <div>
                <label for="profile_type" class="block text-sm font-semibold text-gray-700 mb-1">Тип профиля</label>
                <select id="profile_type" name="profile_type"
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                    <option value="student" {{ old('profile_type') == 'student' ? 'selected' : '' }}>Студент</option>
                    <option value="parent" {{ old('profile_type') == 'parent' ? 'selected' : '' }}>Родитель</option>
                </select>
                @error('profile_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Пароль -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Пароль</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Подтверждение пароля -->
            <div>
                <label for="password_confirmation"
                    class="block text-sm font-semibold text-gray-700 mb-1">Подтверждение</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 shadow-sm text-gray-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
            </div>

            <!-- Скрытое поле role -->
            <input type="hidden" name="role" value="{{ old('profile_type', 'student') }}">

            <!-- Кнопка -->
            <button type="submit"
                class="w-full py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30 transition hover:bg-blue-700">
                Зарегистрироваться
            </button>
        </form>

        <!-- Ссылка на вход -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Уже есть аккаунт?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500">Войти</a>
        </p>
    </div>
</body>

</html>