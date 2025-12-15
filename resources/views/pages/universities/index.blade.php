@extends('layouts.app', ['title' => 'Каталог университетов | GetGrant'])

@section('content')
    <section class="container-custom py-12 space-y-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Каталог университетов</p>
                <h1 class="text-3xl font-bold text-[#1A1A1A]">Университеты‑партнеры и топ‑вузы</h1>
                <p class="text-[#6D7A89]">Фильтрация по стране и уровню обучения.</p>
            </div>
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="country" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все страны</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" @selected(request('country') == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
                <select name="level" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все уровни</option>
                    <option value="bachelor" @selected(request('level') === 'bachelor')>Bachelor</option>
                    <option value="master" @selected(request('level') === 'master')>Master</option>
                    <option value="phd" @selected(request('level') === 'phd')>PhD</option>
                    <option value="all" @selected(request('level') === 'all')>All</option>
                </select>
                <input name="search" value="{{ request('search') }}" placeholder="Название университета"
                       class="px-4 py-2 rounded-lg border border-border text-sm w-60" />
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                    Применить
                </button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($universities as $uni)
                <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $uni->country?->name ?? '—' }}</div>
                            <h2 class="text-xl font-semibold text-[#1A1A1A]">{{ $uni->name }}</h2>
                        </div>
                        @if($uni->level)
                            <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">{{ $uni->level }}</span>
                        @endif
                    </div>
                    @if($uni->description)
                        <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $uni->description }}</p>
                    @endif
                    <div class="grid grid-cols-2 gap-3 text-sm text-[#6D7A89]">
                        <div>Стоимость: {{ $uni->cost_min ? number_format($uni->cost_min) : '—' }} - {{ $uni->cost_max ? number_format($uni->cost_max) : '—' }}</div>
                        <div>Программ: {{ $uni->programs_count ?? 0 }}</div>
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
    </section>
@endsection

