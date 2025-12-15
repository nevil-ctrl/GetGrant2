@extends('layouts.app', ['title' => $university->name . ' | Университет'])

@section('content')
    <section class="container-custom py-12 space-y-8">
        <div class="space-y-2">
            <a href="{{ route('pages.universities') }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">&larr; Все университеты</a>
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="space-y-2">
                    <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $university->country?->name ?? '—' }}</div>
                    <h1 class="text-3xl font-bold text-[#1A1A1A]">{{ $university->name }}</h1>
                    @if($university->website)
                        <a href="{{ $university->website }}" target="_blank" class="text-sm text-[#1055b2] hover:text-[#003b8a]">
                            {{ $university->website }}
                        </a>
                    @endif
                </div>
                <div class="flex items-center gap-3 text-sm text-[#6D7A89]">
                    @if($university->cost_min || $university->cost_max)
                        <div class="px-3 py-2 rounded-lg bg-[#F5F5F5]">
                            Стоимость: {{ $university->cost_min ? number_format($university->cost_min) : '—' }} - {{ $university->cost_max ? number_format($university->cost_max) : '—' }}
                        </div>
                    @endif
                    @if($university->level)
                        <div class="px-3 py-2 rounded-lg bg-[#1055b2]/15 text-[#1055b2] font-semibold">{{ $university->level }}</div>
                    @endif
                </div>
            </div>
            @if($university->description)
                <p class="text-[#6D7A89] max-w-3xl">{{ $university->description }}</p>
            @endif
        </div>

        @if($university->requirements)
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Требования</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($university->requirements as $key => $value)
                        <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm text-sm text-[#1A1A1A]">
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $key }}</div>
                            <div class="font-semibold">{{ is_array($value) ? json_encode($value) : $value }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($university->deadlines)
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Дедлайны</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($university->deadlines as $season => $date)
                        <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm text-sm text-[#1A1A1A]">
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $season }}</div>
                            <div class="font-semibold">{{ $date }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-[#1A1A1A]">Программы</h2>
                <a class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]" href="{{ route('pages.programs') }}?university={{ $university->id }}">Все программы</a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($programs as $program)
                    <article class="p-5 bg-white rounded-xl border border-border/60 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-[#6D7A89] uppercase tracking-wide">{{ $program->field_of_study }}</div>
                            @if($program->is_top)
                                <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">Топ</span>
                            @endif
                        </div>
                        <div class="text-lg font-semibold text-[#1A1A1A]">{{ $program->name }}</div>
                        <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $program->description }}</p>
                        <a href="{{ route('pages.programs.show', $program) }}" class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]">Подробнее</a>
                    </article>
                @empty
                    <p class="text-sm text-[#6D7A89]">Программы не найдены.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

