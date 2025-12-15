@extends('layouts.app', ['title' => $country->name . ' | Страна поступления'])

@section('content')
    <section class="container-custom py-12 space-y-8">
        <div class="space-y-3">
            <a href="{{ route('pages.countries') }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">&larr; Все страны</a>
            <div class="flex items-center gap-3">
                <div class="text-4xl">{{ $country->flag }}</div>
                <div>
                    <h1 class="text-3xl font-bold text-[#1A1A1A]">{{ $country->name }}</h1>
                    <p class="text-[#6D7A89]">{{ $country->description }}</p>
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
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($points as $point)
                        <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm flex gap-2 text-sm text-[#1A1A1A]">
                            <span class="text-[#1055b2]">•</span> {{ $point }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Университеты</h2>
                <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.universities') }}?country={{ $country->id }}">Смотреть все</a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($universities as $uni)
                    <article class="p-5 bg-white rounded-xl border border-border/60 shadow-sm space-y-2">
                        <div class="text-xs text-[#6D7A89] uppercase tracking-wide">Рейтинг: {{ $uni->ranking ?? '—' }}</div>
                        <div class="text-lg font-semibold text-[#1A1A1A]">{{ $uni->name }}</div>
                        <div class="text-sm text-[#6D7A89] line-clamp-3">{{ $uni->description }}</div>
                        <div class="text-xs text-[#6D7A89]">Программ: {{ $uni->programs_count ?? 0 }}</div>
                        <a href="{{ route('pages.universities.show', $uni) }}" class="inline-flex text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]">Подробнее</a>
                    </article>
                @empty
                    <p class="text-sm text-[#6D7A89]">Университеты не найдены.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

