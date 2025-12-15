@extends('layouts.app', ['title' => 'Страны поступления | GetGrant'])

@section('content')
    <section class="container-custom py-12 space-y-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Каталог стран</p>
                <h1 class="text-3xl font-bold text-[#1A1A1A]">Выберите страну для обучения</h1>
                <p class="text-[#6D7A89]">Факты, selling points и партнёрские университеты.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($countries as $country)
                <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">{{ $country->flag }}</div>
                        <div>
                            <div class="text-xl font-semibold text-[#1A1A1A]">{{ $country->name }}</div>
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">код: {{ $country->code }}</div>
                        </div>
                    </div>
                    @if($country->description)
                        <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $country->description }}</p>
                    @endif
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
                    <div class="text-xs text-[#6D7A89]">Университетов: {{ $country->universities_count ?? 0 }}</div>
                    <a href="{{ route('pages.countries.show', $country) }}"
                       class="inline-flex justify-center w-full px-4 py-2.5 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                        Подробнее
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $countries->links() }}
        </div>
    </section>
@endsection

