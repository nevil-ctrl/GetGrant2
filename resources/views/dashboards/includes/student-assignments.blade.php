<div class="space-y-4">
    @if(isset($assignments) && $assignments->count() > 0)
        @foreach($assignments as $assignment)
            @include('partials.assignment-card', ['assignment' => $assignment])
        @endforeach
    @else
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <p class="text-[#6D7A89]">У вас пока нет заданий</p>
        </div>
    @endif
</div>
