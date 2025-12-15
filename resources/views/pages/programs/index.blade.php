@extends('layouts.app', ['title' => 'Каталог программ | GetGrant'])

@section('content')
    <section class="container-custom py-12 space-y-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[#6D7A89] uppercase tracking-wide">Каталог программ</p>
                <h1 class="text-3xl font-bold text-[#1A1A1A]">Образовательные программы</h1>
                <p class="text-[#6D7A89]">Отметки «топ» и краткая справка по профессиям.</p>
            </div>
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="country" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все страны</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" @selected(request('country') == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
                <select name="university" class="px-4 py-2 rounded-lg border border-border text-sm">
                    <option value="">Все университеты</option>
                    @foreach($universities as $uni)
                        <option value="{{ $uni->id }}" @selected(request('university') == $uni->id)>{{ $uni->name }}</option>
                    @endforeach
                </select>
                <input name="field" value="{{ request('field') }}" placeholder="Направление"
                       class="px-4 py-2 rounded-lg border border-border text-sm w-52" />
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                    Применить
                </button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($programs as $program)
                <article class="p-6 bg-white rounded-2xl border border-border/60 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $program->field_of_study }}</div>
                            <h2 class="text-xl font-semibold text-[#1A1A1A]">{{ $program->name }}</h2>
                            <div class="text-sm text-[#6D7A89]">{{ $program->university?->name }}</div>
                        </div>
                        @if($program->is_top)
                            <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">Топ</span>
                        @endif
                    </div>
                    <p class="text-sm text-[#6D7A89] line-clamp-3">{{ $program->description }}</p>
                    @if($program->career_info)
                        <div class="text-xs text-[#6D7A89]">Карьерные пути: {{ collect($program->career_info)->join(', ') }}</div>
                    @endif
                    <a href="{{ route('pages.programs.show', $program) }}"
                       class="inline-flex justify-center w-full px-4 py-2.5 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">
                        Подробнее
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $programs->appends(request()->query())->links() }}
        </div>
    </section>
@endsection

