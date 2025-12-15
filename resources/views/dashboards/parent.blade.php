@extends('layouts.app', ['title' => 'Личный кабинет родителя'])

@section('content')
    <section class="container-custom py-10 space-y-6">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Личный кабинет</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Здравствуйте, {{ $user->name }}!</h1>
            <p class="text-sm text-[#6D7A89]">Здесь вы можете отслеживать процесс поступления ребёнка.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Менеджер</h2>
                <p class="text-sm text-[#6D7A89]">Появится после назначения менеджера.</p>
            </div>
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-3">
                <h2 class="text-xl font-semibold text-[#1A1A1A]">Документы</h2>
                <p class="text-sm text-[#6D7A89]">Статус загрузки документов отобразится здесь.</p>
            </div>
        </div>
    </section>
@endsection
