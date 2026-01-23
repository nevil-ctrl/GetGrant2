@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="container-custom py-10">
        <!-- Заголовок дашборда -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#1A1A1A]">
                @if($role === 'student')
                    Привет, {{ $user->name }}!
                @elseif($role === 'parent')
                    Здравствуйте, {{ $user->name }}!
                @elseif($role === 'manager')
                    Панель менеджера
                @endif
            </h1>
            <p class="text-sm text-[#6D7A89] mt-2">
                @if($role === 'student')
                    Изучайте курсы, выполняйте задания и отслеживайте прогресс
                @elseif($role === 'parent')
                    Отслеживайте прогресс вашего ребенка
                @elseif($role === 'manager')
                    Управляйте студентами, создавайте уроки и проверяйте задания
                @endif
            </p>
        </div>

        <!-- Сообщения об успехе -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Вкладки LMS -->
        <div class="mb-6 border-b border-border/60">
            <nav class="flex space-x-8" role="tablist">
                <button class="tab-button {{ session('active_tab') !== 'lessons' && session('active_tab') !== 'assignments' && session('active_tab') !== 'application' && session('active_tab') !== 'students' ? 'active' : '' }} py-4 px-1 border-b-2 {{ session('active_tab') !== 'lessons' && session('active_tab') !== 'assignments' && session('active_tab') !== 'application' && session('active_tab') !== 'students' ? 'border-[#1055b2] text-[#1055b2]' : 'border-transparent text-[#6D7A89]' }} font-semibold hover:text-[#1055b2]" 
                        data-tab="overview">
                    Обзор
                </button>
                @if($role === 'student' || $role === 'manager')
                    <button class="tab-button {{ session('active_tab') === 'lessons' ? 'active border-[#1055b2] text-[#1055b2]' : 'border-transparent text-[#6D7A89]' }} py-4 px-1 border-b-2 font-semibold hover:text-[#1055b2]" 
                            data-tab="lessons">
                        Уроки
                    </button>
                    <button class="tab-button {{ session('active_tab') === 'assignments' ? 'active border-[#1055b2] text-[#1055b2]' : 'border-transparent text-[#6D7A89]' }} py-4 px-1 border-b-2 font-semibold hover:text-[#1055b2]" 
                            data-tab="assignments">
                        Задания
                    </button>
                @endif
                @if($role === 'student' || $role === 'parent')
                    <button class="tab-button py-4 px-1 border-b-2 border-transparent font-semibold text-[#6D7A89] hover:text-[#1055b2]" 
                            data-tab="application">
                        Поступление
                    </button>
                @endif
                @if($role === 'manager')
                    <button class="tab-button py-4 px-1 border-b-2 border-transparent font-semibold text-[#6D7A89] hover:text-[#1055b2]" 
                            data-tab="students">
                        Студенты
                    </button>
                @endif
            </nav>
        </div>

        <!-- Контент вкладок -->
        <div class="tab-content">
            <!-- Вкладка: Обзор -->
            <div id="tab-overview" class="tab-pane {{ session('active_tab') !== 'lessons' && session('active_tab') !== 'assignments' && session('active_tab') !== 'application' && session('active_tab') !== 'students' ? 'active' : 'hidden' }}">
                @if($role === 'student')
                    @include('dashboards.includes.student-overview')
                @elseif($role === 'parent')
                    @include('dashboards.includes.parent-overview')
                @elseif($role === 'manager')
                    @include('dashboards.includes.manager-overview')
                @endif
            </div>

            <!-- Вкладка: Уроки -->
            @if($role === 'student' || $role === 'manager')
                <div id="tab-lessons" class="tab-pane {{ session('active_tab') === 'lessons' ? 'active' : 'hidden' }}">
                    @if($role === 'student')
                        @include('dashboards.includes.student-lessons')
                    @elseif($role === 'manager')
                        @include('dashboards.includes.manager-lessons')
                    @endif
                </div>
            @endif

            <!-- Вкладка: Задания -->
            @if($role === 'student' || $role === 'manager')
                <div id="tab-assignments" class="tab-pane {{ session('active_tab') === 'assignments' ? 'active' : 'hidden' }}">
                    @if($role === 'student')
                        @include('dashboards.includes.student-assignments')
                    @elseif($role === 'manager')
                        @include('dashboards.includes.manager-assignments')
                    @endif
                </div>
            @endif

            <!-- Вкладка: Поступление -->
            @if($role === 'student' || $role === 'parent')
                <div id="tab-application" class="tab-pane hidden">
                    @if($role === 'student')
                        @include('dashboards.includes.student-application')
                    @elseif($role === 'parent')
                        @include('dashboards.includes.parent-application')
                    @endif
                </div>
            @endif

            <!-- Вкладка: Студенты (для менеджера) -->
            @if($role === 'manager')
                <div id="tab-students" class="tab-pane hidden">
                    @include('dashboards.includes.manager-students')
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Переключение вкладок
        document.addEventListener('DOMContentLoaded', function() {
            // Если есть активная вкладка из сессии, активируем её
            @if(session('active_tab'))
                const activeTab = '{{ session('active_tab') }}';
                const activeButton = document.querySelector(`[data-tab="${activeTab}"]`);
                const activePane = document.getElementById('tab-' + activeTab);
                
                if (activeButton && activePane) {
                    // Убираем активный класс у всех
                    document.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('active', 'border-[#1055b2]', 'text-[#1055b2]');
                        btn.classList.add('border-transparent', 'text-[#6D7A89]');
                    });
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    });
                    
                    // Активируем нужную вкладку
                    activeButton.classList.add('active', 'border-[#1055b2]', 'text-[#1055b2]');
                    activeButton.classList.remove('border-transparent', 'text-[#6D7A89]');
                    activePane.classList.remove('hidden');
                    activePane.classList.add('active');
                }
            @endif

            // Обработчики кликов на вкладки
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.dataset.tab;
                    
                    // Убираем активный класс у всех кнопок
                    document.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('active', 'border-[#1055b2]', 'text-[#1055b2]');
                        btn.classList.add('border-transparent', 'text-[#6D7A89]');
                    });
                    
                    // Добавляем активный класс к текущей кнопке
                    this.classList.add('active', 'border-[#1055b2]', 'text-[#1055b2]');
                    this.classList.remove('border-transparent', 'text-[#6D7A89]');
                    
                    // Скрываем все вкладки
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    });
                    
                    // Показываем выбранную вкладку
                    const targetPane = document.getElementById('tab-' + tabName);
                    if (targetPane) {
                        targetPane.classList.remove('hidden');
                        targetPane.classList.add('active');
                    }
                });
            });
        });
    </script>
    @vite('resources/js/widgets.tsx')
@endpush
