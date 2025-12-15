@extends('layouts.app', ['title' => 'Онлайн‑подготовка | GetGrant'])

@section('content')
    <section class="container-custom py-12 space-y-8">
        <div class="space-y-3">
            <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Онлайн‑подготовка</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Индивидуальные занятия и подготовка к экзаменам</h1>
            <p class="text-lg text-[#6D7A89] max-w-3xl">Английский, IELTS, SAT, профориентация. Запишитесь на консультацию — подберем программу и составим расписание.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('register.form') }}" class="px-6 py-3 rounded-xl bg-[#1055b2] text-white font-semibold shadow hover:bg-[#003b8a] transition-colors">
                    Записаться
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl border border-border text-sm font-semibold text-[#1A1A1A] hover:border-[#1055b2] hover:text-[#1055b2] transition-colors">
                    Я уже клиент
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['title' => 'Английский', 'desc' => 'Готовим к академическому английскому и speaking.'],
                ['title' => 'IELTS', 'desc' => 'Полный цикл подготовки, пробные тесты, тайминг.'],
                ['title' => 'SAT', 'desc' => 'Математика и Evidence-Based Reading & Writing.'],
                ['title' => 'Профориентация', 'desc' => 'Выбор направления, карьерные треки и вузовский матчинг.'],
            ] as $course)
                <div class="p-5 bg-white rounded-2xl border border-border/60 shadow-sm space-y-2">
                    <div class="text-lg font-semibold text-[#1A1A1A]">{{ $course['title'] }}</div>
                    <p class="text-sm text-[#6D7A89]">{{ $course['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="p-6 bg-[#F5F5F5] rounded-2xl border border-border/60 grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Как проходит обучение</h2>
                <ul class="space-y-2 text-sm text-[#1A1A1A]">
                    <li>• Индивидуальные занятия в Zoom/Meet</li>
                    <li>• Домашние задания и трекинг прогресса</li>
                    <li>• Наставник и обратная связь после каждого урока</li>
                    <li>• Записи занятий и материалы в личном кабинете</li>
                </ul>
            </div>
            <div class="space-y-3">
                <div class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Следующий шаг</div>
                <div class="text-lg font-semibold text-[#1A1A1A]">Оставьте контакты — менеджер свяжется и подберет слот.</div>
                <a href="{{ route('register.form') }}" class="inline-flex justify-center px-6 py-3 rounded-xl bg-[#1055b2] text-white font-semibold hover:bg-[#003b8a] transition-colors">
                    Получить консультацию
                </a>
            </div>
        </div>
    </section>
@endsection

