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
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Страны</p>
                <h2 class="text-3xl font-bold text-[#1A1A1A]">Куда можно поступить</h2>
            </div>
            <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.countries') }}">Смотреть все</a>
        </div>
        @if($countries->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($countries as $country)
                    <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-3">
                            <div class="text-4xl flex-shrink-0">{{ $country->flag ?? '🌍' }}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xl font-semibold text-[#1A1A1A] mb-2">{{ $country->name }}</div>
                                @if($country->description_ru)
                                    <div class="text-sm text-[#6D7A89] leading-relaxed line-clamp-4">{{ \Illuminate\Support\Str::limit($country->description_ru, 150) }}</div>
                                @elseif($country->description)
                                    <div class="text-sm text-[#6D7A89] line-clamp-3">{{ $country->description }}</div>
                                @endif
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
                            <ul class="space-y-2 pt-2 border-t border-border/30">
                                @foreach(array_slice($points, 0, 3) as $point)
                                    <li class="text-sm text-[#1A1A1A] flex gap-2">
                                        <span class="text-[#1055b2] font-bold flex-shrink-0">•</span> 
                                        <span>{{ is_array($point) ? ($point['value'] ?? '') : $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('pages.countries.show', $country->code) }}" class="inline-block text-sm font-semibold text-[#1055b2] hover:text-[#003b8a] transition-colors">
                            Подробнее →
                        </a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-border/60">
                <p class="text-[#6D7A89]">Страны будут добавлены в ближайшее время</p>
            </div>
        @endif
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
        @if($partnerUniversities->count() > 0)
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($partnerUniversities as $uni)
                    <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm hover:shadow-md transition-shadow">
                        <div class="text-xs text-[#6D7A89] uppercase tracking-wide mb-1">{{ $uni->country?->name ?? '—' }}</div>
                        <div class="font-semibold text-[#1A1A1A] mb-2 line-clamp-2">{{ $uni->name }}</div>
                        @if($uni->programs_count > 0)
                            <div class="text-xs text-[#6D7A89]">{{ $uni->programs_count }} {{ $uni->programs_count == 1 ? 'программа' : 'программ' }}</div>
                        @endif
                        <a href="{{ route('pages.universities.show', $uni) }}" class="inline-block mt-2 text-xs font-semibold text-[#1055b2] hover:text-[#003b8a]">
                            Подробнее →
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-border/60">
                <p class="text-[#6D7A89]">Университеты будут добавлены в ближайшее время</p>
            </div>
        @endif
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

