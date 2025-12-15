@extends('layouts.app', ['title' => 'GetGrant — подготовка к поступлению за рубеж'])

@section('content')
    <section class="bg-[#F5F5F5]">
        <div class="container-custom grid lg:grid-cols-2 gap-10 py-16">
            <div class="space-y-6">
                <p class="text-sm font-semibold text-[#1055b2] uppercase tracking-wide">Подготовка к поступлению</p>
                <h1 class="text-4xl md:text-5xl font-bold text-[#1A1A1A] leading-tight">
                    Поступайте в ведущие университеты мира с поддержкой GetGrant
                </h1>
                <p class="text-lg text-[#6D7A89] max-w-2xl">
                    Помогаем ученикам 9–11 классов и их родителям пройти весь путь: от выбора страны и программы до визы и вылета.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('register.form') }}" class="inline-flex justify-center px-6 py-3 rounded-xl bg-[#1055b2] text-white font-semibold shadow-lg shadow-[#1055b2]/20 hover:bg-[#003b8a] transition-colors">
                        Начать подготовку
                    </a>
                    <a href="{{ route('pages.online-prep') }}" class="inline-flex justify-center px-6 py-3 rounded-xl border border-border text-sm font-semibold text-[#1A1A1A] hover:border-[#1055b2] hover:text-[#1055b2] transition-colors">
                        Получить консультацию
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-4">
                    <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm">
                        <div class="text-2xl font-bold text-[#1A1A1A]">1500+</div>
                        <div class="text-sm text-[#6D7A89]">поступлений с 2015 года</div>
                    </div>
                    <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm">
                        <div class="text-2xl font-bold text-[#1A1A1A]">50+</div>
                        <div class="text-sm text-[#6D7A89]">университетов‑партнеров</div>
                    </div>
                    <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm">
                        <div class="text-2xl font-bold text-[#1A1A1A]">12</div>
                        <div class="text-sm text-[#6D7A89]">стран для поступления</div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="relative h-full">
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-[#1055b2] to-[#003b8a] opacity-10 blur-3xl"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl border border-border/70 p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-[#1055b2]/15 flex items-center justify-center text-[#1055b2] font-bold">GG</div>
                            <div>
                                <div class="font-semibold text-[#1A1A1A]">Назначим менеджера</div>
                                <div class="text-sm text-[#6D7A89]">личный куратор после регистрации</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="p-4 bg-[#F5F5F5] rounded-xl">
                                <div class="text-sm text-[#6D7A89] mb-1">Шаг 1</div>
                                <div class="font-semibold text-[#1A1A1A]">Консультация и выбор страны</div>
                            </div>
                            <div class="p-4 bg-[#F5F5F5] rounded-xl">
                                <div class="text-sm text-[#6D7A89] mb-1">Шаг 2</div>
                                <div class="font-semibold text-[#1A1A1A]">Подбор университета и программы</div>
                            </div>
                            <div class="p-4 bg-[#F5F5F5] rounded-xl">
                                <div class="text-sm text-[#6D7A89] mb-1">Шаг 3</div>
                                <div class="font-semibold text-[#1A1A1A]">Документы, подача, оффер, виза, вылет</div>
                            </div>
                        </div>
                    <a href="{{ route('register.form') }}" class="inline-flex justify-center w-full px-5 py-3 rounded-xl bg-[#1055b2] text-white font-semibold hover:bg-[#003b8a] transition-colors">
                            Записаться на консультацию
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="why" class="container-custom py-16 space-y-6">
        <div class="flex items-center gap-3">
            <span class="h-1.5 w-10 bg-[#1055b2] rounded-full"></span>
            <p class="text-sm font-semibold uppercase tracking-wide text-[#6D7A89]">Почему GetGrant</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-5 bg-white rounded-2xl border border-border/60 shadow-sm">
                <div class="text-lg font-semibold text-[#1A1A1A] mb-2">Лицензии и аккредитации</div>
                <p class="text-sm text-[#6D7A89]">Все документы доступны в личном кабинете и на сайте.</p>
            </div>
            <div class="p-5 bg-white rounded-2xl border border-border/60 shadow-sm">
                <div class="text-lg font-semibold text-[#1A1A1A] mb-2">Менеджер за каждым лидом</div>
                <p class="text-sm text-[#6D7A89]">Контакты, чат и статус поступления всегда под рукой.</p>
            </div>
            <div class="p-5 bg-white rounded-2xl border border-border/60 shadow-sm">
                <div class="text-lg font-semibold text-[#1A1A1A] mb-2">Онлайн‑подготовка</div>
                <p class="text-sm text-[#6D7A89]">Английский, IELTS, SAT, профориентация — занятия в удобное время.</p>
            </div>
            <div class="p-5 bg-white rounded-2xl border border-border/60 shadow-sm">
                <div class="text-lg font-semibold text-[#1A1A1A] mb-2">Прозрачная воронка</div>
                <p class="text-sm text-[#6D7A89]">От регистрации до вылета — на каждой стадии понятные действия.</p>
            </div>
        </div>
    </section>

    <section class="container-custom py-16 space-y-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Топ страны</p>
                <h2 class="text-3xl font-bold text-[#1A1A1A]">Популярные направления</h2>
            </div>
            <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.countries') }}">Смотреть все</a>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularCountries as $country)
                <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">{{ $country->flag }}</div>
                        <div>
                            <div class="text-xl font-semibold text-[#1A1A1A]">{{ $country->name }}</div>
                            <div class="text-sm text-[#6D7A89]">{{ $country->description }}</div>
                        </div>
                    </div>
                    @php
                        $points = $country->selling_points;
                        if (! is_array($points)) {
                            $decoded = json_decode((string) $points, true);
                            $points = is_array($decoded) ? $decoded : [];
                        }
                    @endphp
                    @if(!empty($points))
                        <ul class="space-y-2">
                            @foreach($points as $point)
                                <li class="text-sm text-[#1A1A1A] flex gap-2">
                                    <span class="text-[#1055b2]">•</span> {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="container-custom py-16 space-y-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Топ программы</p>
                <h2 class="text-3xl font-bold text-[#1A1A1A]">Популярные программы</h2>
            </div>
            <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.programs') }}">Все программы</a>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularPrograms as $program)
                <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xl font-semibold text-[#1A1A1A]">{{ $program->name }}</div>
                            <div class="text-sm text-[#6D7A89]">{{ $program->field_of_study }}</div>
                        </div>
                        @if($program->is_top)
                            <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">Топ</span>
                        @endif
                    </div>
                    <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $program->description }}</p>
                    <div class="text-sm text-[#1A1A1A]">
                        Университет: {{ $program->university?->name }}
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="container-custom py-16 space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Партнеры</p>
                <h2 class="text-3xl font-bold text-[#1A1A1A]">Университеты‑партнеры</h2>
            </div>
            <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.universities') }}">Смотреть все</a>
        </div>
        <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($partnerUniversities as $uni)
                <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm">
                    <div class="text-sm text-[#6D7A89] mb-1">{{ $uni->country?->name }}</div>
                    <div class="font-semibold text-[#1A1A1A]">{{ $uni->name }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="cta" class="bg-[#1055b2] text-white py-16">
        <div class="container-custom grid lg:grid-cols-2 gap-8 items-center">
            <div class="space-y-3">
                <p class="text-sm uppercase tracking-wide text-white/80">Готовы начать?</p>
                <h2 class="text-3xl md:text-4xl font-bold">Запишитесь на бесплатную консультацию</h2>
                <p class="text-white/80">Подберем страну, университет и программу, а также расскажем про дедлайны и бюджет.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('register.form') }}" class="inline-flex justify-center px-6 py-3 rounded-xl bg-white text-[#1055b2] font-semibold shadow-md hover:bg-slate-100 transition-colors">
                    Записаться
                </a>
                <a href="{{ route('pages.online-prep') }}" class="inline-flex justify-center px-6 py-3 rounded-xl border border-white/60 text-white font-semibold hover:bg-white/10 transition-colors">
                    Узнать о подготовке
                </a>
            </div>
        </div>
    </section>
@endsection

