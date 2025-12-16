<header class="border-b border-border/60 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/60 sticky top-0 z-30">
    <div class="container-custom flex items-center justify-between py-4 gap-6">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('img/logo/logo.png') }}" alt="GetGrant" class="h-10 w-auto">
                <div class="leading-tight">
                    <div class="text-lg font-bold text-[#1055b2]">GetGrant</div>
                    <div class="text-xs text-[#6D7A89]">Поступление за рубеж</div>
                </div>
            </a>
        </div>

        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-[#1A1A1A]">
            <a href="{{ route('pages.home') }}" class="hover:text-[#1055b2] transition-colors">Главная</a>
            <a href="{{ route('pages.home') }}" class="hover:text-[#1055b2] transition-colors">dhfvefbhv</a>
            <a href="{{ route('pages.countries') }}" class="hover:text-[#1055b2] transition-colors">Страны</a>
            <a href="{{ route('pages.universities') }}" class="hover:text-[#1055b2] transition-colors">Университеты</a>
            <a href="{{ route('pages.programs') }}" class="hover:text-[#1055b2] transition-colors">Программы</a>
            <a href="{{ route('pages.online-prep') }}" class="hover:text-[#1055b2] transition-colors">Онлайн‑подготовка</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard.redirect') }}"
                   class="hidden md:inline-flex px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold shadow hover:bg-[#003b8a] transition-colors">
                    Личный кабинет
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-[#1055b2] hover:text-[#003b8a]">
                    Войти
                </a>
                <a href="{{ route('register.form') }}"
                   class="hidden md:inline-flex px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold shadow hover:bg-[#003b8a] transition-colors">
                    Начать подготовку
                </a>
            @endauth
        </div>
    </div>
</header>

