<div class="space-y-6">
    @if(isset($categories) && $categories->count() > 0)
        @foreach($categories as $category)
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="text-sm text-[#6D7A89] mb-4">{{ $category->description }}</p>
                @endif
                
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($category->lessons as $lesson)
                        @include('partials.lesson-card', ['lesson' => $lesson, 'user' => $user])
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <p class="text-[#6D7A89]">Пока нет доступных уроков</p>
        </div>
    @endif
</div>
