<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | GetGrant</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen px-4">
<div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
    <div class="mb-6 text-center">
        <p class="text-sm uppercase tracking-wide text-slate-400">доступ к платформе</p>
        <h1 class="text-2xl font-bold text-slate-900">Вход в аккаунт</h1>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            @error('email')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700" for="password">Пароль</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Запомнить меня
            </label>
            <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-500">
                Забыли пароль?
            </a>
        </div>

        <button type="submit"
                class="w-full rounded-xl bg-blue-600 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-700">
            Войти
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        Нет аккаунта?
        <a href="{{ route('register.form') }}" class="font-semibold text-blue-600 hover:text-blue-500">Создать</a>
    </p>
</div>
</body>
</html>
