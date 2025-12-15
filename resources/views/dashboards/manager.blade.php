@extends('layouts.app', ['title' => 'Кабинет менеджера'])

@section('content')
    <section class="container-custom py-10 space-y-6">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Менеджер</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Здравствуйте, {{ $user->name }}!</h1>
            <p class="text-sm text-[#6D7A89]">Управляйте закреплёнными студентами и их статусами.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Активные лиды</h2>
                <p class="text-sm text-[#6D7A89]">Скоро здесь появится список студентов.</p>
            </div>
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Последние обновления</h2>
                <p class="text-sm text-[#6D7A89]">События и изменения статусов будут отображаться здесь.</p>
            </div>
        </div>
    </section>
@endsection
