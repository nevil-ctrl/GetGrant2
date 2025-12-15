@extends('layouts.app', ['title' => $program->name . ' | Программа'])

@section('content')
    <section class="container-custom py-12 space-y-8">
        <div class="space-y-2">
            <a href="{{ route('pages.programs') }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">&larr; Все программы</a>
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="space-y-2">
                    <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $program->field_of_study }}</div>
                    <h1 class="text-3xl font-bold text-[#1A1A1A]">{{ $program->name }}</h1>
                    <div class="text-sm text-[#6D7A89]">Университет: {{ $program->university?->name }}</div>
                </div>
                @if($program->is_top)
                    <span class="px-4 py-2 rounded-full bg-[#1055b2]/15 text-[#1055b2] font-semibold text-sm">Топовая программа</span>
                @endif
            </div>
            @if($program->description)
                <p class="text-[#6D7A89] max-w-3xl">{{ $program->description }}</p>
            @endif
        </div>

        @if($program->career_info)
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Карьерная информация</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($program->career_info as $key => $value)
                        <div class="p-4 bg-white rounded-xl border border-border/60 shadow-sm text-sm text-[#1A1A1A]">
                            <div class="text-xs text-[#6D7A89] uppercase tracking-wide">{{ $key }}</div>
                            <div class="font-semibold">{{ is_array($value) ? json_encode($value) : $value }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="p-6 bg-[#F5F5F5] rounded-2xl border border-border/60 space-y-3">
            <div class="text-lg font-semibold text-[#1A1A1A]">Заинтересовала программа?</div>
            <p class="text-sm text-[#6D7A89]">Авторизуйтесь, чтобы назначить менеджера и обсудить детали поступления.</p>
            <div class="flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('dashboard.redirect') }}" class="px-5 py-2.5 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">Перейти в кабинет</a>
                @else
                    <a href="{{ route('register.form') }}" class="px-5 py-2.5 rounded-lg bg-[#1055b2] text-white text-sm font-semibold hover:bg-[#003b8a] transition-colors">Зарегистрироваться</a>
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-lg border border-border text-sm font-semibold text-[#1A1A1A] hover:border-[#1055b2] hover:text-[#1055b2] transition-colors">Войти</a>
                @endauth
            </div>
        </div>
    </section>
@endsection

