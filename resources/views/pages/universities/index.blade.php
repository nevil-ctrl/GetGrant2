@extends('layouts.app', ['title' => 'Каталог университетов | GetGrant'])

@section('content')
    <section class="container-custom py-12 space-y-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Каталог университетов</p>
                <h1 class="text-3xl font-bold text-[#1A1A1A]">Университеты‑партнеры и топ‑вузы</h1>
                <p class="text-[#6D7A89]">Фильтрация по стране и уровню обучения.</p>
            </div>
            <form method="GET" class="flex flex-wrap gap-3 p-4 bg-white rounded-xl border border-border/60">
                <select name="country" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все страны</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" @selected(request('country') == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
                <select name="level" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все уровни</option>
                    <option value="bachelor" @selected(request('level') === 'bachelor')>Бакалавриат</option>
                    <option value="master" @selected(request('level') === 'master')>Магистратура</option>
                    <option value="phd" @selected(request('level') === 'phd')>PhD</option>
                    <option value="all" @selected(request('level') === 'all')>Все уровни</option>
                </select>
                <input name="search" value="{{ request('search') }}" placeholder="Название университета"
                       class="px-4 py-2 rounded-lg border border-border text-sm flex-1 min-w-[200px]" />
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                    Применить
                </button>
                @if(request()->hasAny(['country', 'level', 'search']))
                    <a href="{{ route('pages.universities') }}" class="px-4 py-2 rounded-lg border border-border text-sm text-[#6D7A89] hover:bg-gray-50 transition-colors">
                        Сбросить
                    </a>
                @endif
            </form>
        </div>

        @if($universities->isEmpty())
            <div class="text-center py-12">
                <p class="text-[#6D7A89]">Университеты не найдены</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($universities as $uni)
                    <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $uni->country?->name ?? '—' }}</div>
                                <h2 class="text-xl font-semibold text-[#1A1A1A]">{{ $uni->name }}</h2>
                            </div>
                            @if($uni->level && $uni->level !== 'all')
                                <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold whitespace-nowrap">
                                    @if($uni->level === 'bachelor') Бакалавриат
                                    @elseif($uni->level === 'master') Магистратура
                                    @elseif($uni->level === 'phd') PhD
                                    @endif
                                </span>
                            @endif
                        </div>
                        @if($uni->description)
                            <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $uni->description }}</p>
                        @endif
                        <div class="grid grid-cols-2 gap-3 text-sm text-[#6D7A89]">
                            <div>
                                <span class="font-semibold">Стоимость:</span><br>
                                @if($uni->cost_min && $uni->cost_max)
                                    {{ number_format($uni->cost_min, 0, ',', ' ') }} - {{ number_format($uni->cost_max, 0, ',', ' ') }} $
                                @elseif($uni->cost_min)
                                    от {{ number_format($uni->cost_min, 0, ',', ' ') }} $
                                @else
                                    —
                                @endif
                            </div>
                            <div>
                                <span class="font-semibold">Программ:</span><br>
                                {{ $uni->programs_count ?? 0 }}
                            </div>
                        </div>
                        <a href="{{ route('pages.universities.show', $uni) }}"
                           class="inline-flex justify-center w-full px-4 py-2.5 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                            Подробнее
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $universities->appends(request()->query())->links() }}
            </div>
        @endif
    </section>
@endsection

