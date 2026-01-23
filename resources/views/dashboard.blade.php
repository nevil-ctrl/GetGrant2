<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GetGrant</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-slate-100 min-h-screen">
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Fortify dashboard</p>
            <h1 class="text-3xl font-bold text-slate-900">Hello, {{ auth()->user()->name ?? 'Explorer' }} 👋</h1>
            <p class="text-slate-500">Сводка по аккаунту и быстрые действия.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                На главную
            </a>
            <a href="{{ url('/admin/login') }}"
               class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                Adminka
            </a>
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-600 font-semibold">
                Выйти
            </button>
        </form>
        </div>
    </div>
</header>

<main class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <section class="grid gap-6 md:grid-cols-3">
            <article class="rounded-xl bg-white p-6 shadow">
                <p class="text-sm text-slate-500">Статус профиля</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">Активен</p>
                <p class="mt-4 text-sm text-slate-500">Последний вход: {{ now()->format('d.m.Y H:i') }}</p>
            </article>
            <article class="rounded-xl bg-white p-6 shadow">
                <p class="text-sm text-slate-500">Новые уведомления</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">3</p>
                <p class="mt-4 text-sm text-green-600">+1 vs вчера</p>
            </article>
            <article class="rounded-xl bg-white p-6 shadow">
                <p class="text-sm text-slate-500">Назначенный менеджер</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">Пока не назначен</p>
                <p class="mt-4 text-sm text-slate-500">Появится автоматически после подачи заявки</p>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl bg-white p-6 shadow lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Этапы поступления</h2>
                    <span class="text-xs font-semibold uppercase text-blue-600">в разработке</span>
                </div>
                <div class="mt-6 space-y-5">
                    @foreach ([
    ['title' => 'Консультация', 'status' => 'done'],
    ['title' => 'Подготовка документов', 'status' => 'in-progress'],
    ['title' => 'Подача заявки', 'status' => 'todo'],
    ['title' => 'Оффер университета', 'status' => 'todo'],
    ['title' => 'Виза и вылет', 'status' => 'todo'],
] as $step)
                        <div class="flex items-center gap-4">
                            @php($colors = [
        'done' => 'bg-green-500',
        'in-progress' => 'bg-amber-500',
        'todo' => 'bg-slate-300',
    ])
                            <span class="h-3 w-3 rounded-full {{ $colors[$step['status']] }}"></span>
                            <p class="text-sm font-medium text-slate-800">{{ $step['title'] }}</p>
                            <div class="ml-auto text-xs uppercase tracking-wide text-slate-400">
                                {{ $step['status'] === 'done' ? 'Завершено' : ($step['status'] === 'in-progress' ? 'В процессе' : 'Ожидает') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow">
                <h2 class="text-lg font-semibold text-slate-900">Быстрые действия</h2>
                <div class="mt-4 space-y-3">
                    <a href="#" class="block rounded-lg border border-slate-100 px-4 py-3 text-sm font-semibold text-blue-600 hover:bg-blue-50">
                        Забронировать консультацию
                    </a>
                    <a href="#" class="block rounded-lg border border-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Загрузить документы
                    </a>
                    <a href="#" class="block rounded-lg border border-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Связаться с поддержкой
                    </a>
                </div>
            </div>
        </section>
    </div>
</main>
</body>
</html>

