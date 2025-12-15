@extends('layouts.app', ['title' => 'Личный кабинет студента'])

@section('content')
    @php
        $manager = $user->manager;
        $timelineProps = $timelineProps ?? ['items' => []];
        $chatProps = $chatProps ?? [
            'userName' => $user->name,
            'managerName' => $manager->name ?? 'Ваш менеджер',
            'messages' => [],
        ];
    @endphp

    <section class="container-custom py-10 space-y-8">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Личный кабинет</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Привет, {{ $user->name }}!</h1>
            <p class="text-sm text-[#6D7A89]">Следите за статусом поступления и общайтесь с менеджером</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div data-widget="timeline" data-props='@json($timelineProps)'></div>
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-[#1A1A1A]">Документы</h2>
                            <p class="text-sm text-[#6D7A89]">Загрузите аттестаты, рекомендации и т.д.</p>
                        </div>
                        <a href="#" class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]">Перейти</a>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4 text-sm text-[#6D7A89]">
                        <div class="p-4 rounded-xl bg-[#F5F5F5]">Аттестат — не загружено</div>
                        <div class="p-4 rounded-xl bg-[#F5F5F5]">IELTS сертификат — не загружено</div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-[#6D7A89]">Ваш менеджер</p>
                            <p class="text-lg font-semibold text-[#1A1A1A]">{{ $manager->name ?? 'Будет назначен' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">
                            {{ $manager?->role === 'manager' ? 'Онлайн' : 'В обработке' }}
                        </span>
                    </div>
                    <div class="text-sm text-[#6D7A89] space-y-1">
                        <p>Email: {{ $manager->email ?? '—' }}</p>
                        <p>Телефон: {{ $manager->phone ?? '—' }}</p>
                    </div>
                </div>

                <div class="min-h-[480px]" data-widget="chat" data-props='@json($chatProps)'></div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/widgets.ts')
@endpush
