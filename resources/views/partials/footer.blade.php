<footer class="border-t border-border/60 bg-white py-10 mt-16">
    <div class="container-custom grid gap-6 md:grid-cols-4">
        <div class="space-y-3">
            <div class="text-lg font-bold text-[#1055b2]">GetGrant</div>
            <p class="text-sm text-[#6D7A89]">Подготовка к поступлению за рубеж с персональным сопровождением.</p>
        </div>
        <div>
            <div class="text-sm font-semibold text-[#1A1A1A] mb-3">Каталоги</div>
            <ul class="space-y-2 text-sm text-[#6D7A89]">
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.countries') }}">Страны</a></li>
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.universities') }}">Университеты</a></li>
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.programs') }}">Программы</a></li>
            </ul>
        </div>
        <div>
            <div class="text-sm font-semibold text-[#1A1A1A] mb-3">Сервис</div>
            <ul class="space-y-2 text-sm text-[#6D7A89]">
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.online-prep') }}">Онлайн‑подготовка</a></li>
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.home') }}#why">Почему мы</a></li>
                <li><a class="hover:text-[#1055b2]" href="{{ route('pages.home') }}#cta">Получить консультацию</a></li>
            </ul>
        </div>
        <div class="space-y-3">
            <div class="text-sm font-semibold text-[#1A1A1A]">Контакты</div>
            <p class="text-sm text-[#6D7A89]">info@getgrant.com</p>
            <p class="text-sm text-[#6D7A89]">+7 (000) 000‑00‑00</p>
            <a href="{{ route('register.form') }}"
               class="inline-flex px-4 py-2 rounded-lg bg-[#1055b2] text-white text-sm font-semibold shadow hover:bg-[#003b8a] transition-colors">
                Получить консультацию
            </a>
        </div>
    </div>
    <div class="container-custom mt-8 text-xs text-[#6D7A89]">© {{ date('Y') }} GetGrant. Все права защищены.</div>
</footer>

