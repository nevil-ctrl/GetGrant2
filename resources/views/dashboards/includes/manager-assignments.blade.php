<div class="space-y-6">
    <h2 class="text-2xl font-semibold text-[#1A1A1A] mb-4">Задания на проверку</h2>
    
    @if(isset($pendingAssignments) && $pendingAssignments->count() > 0)
        <div class="space-y-3">
            @foreach($pendingAssignments as $assignment)
                @include('partials.assignment-review-card', ['assignment' => $assignment])
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <p class="text-[#6D7A89]">Нет заданий на проверку</p>
        </div>
    @endif
</div>
