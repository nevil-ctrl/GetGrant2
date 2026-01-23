@if(isset($application))
    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
        <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Статус поступления</h2>
        <!-- Таймлайн поступления -->
        <div class="space-y-4">
            @php
                $stages = [
                    'consultation' => 'Консультация',
                    'documents' => 'Документы',
                    'submission' => 'Подача заявки',
                    'offer' => 'Оффер',
                    'visa' => 'Виза',
                    'departure' => 'Вылет',
                ];
                $currentStatus = $application->status ?? 'consultation';
            @endphp
            
            @foreach($stages as $key => $label)
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                        {{ $key === $currentStatus ? 'bg-[#1055b2] text-white' : 'bg-gray-200 text-gray-500' }}">
                        {{ array_search($key, array_keys($stages)) + 1 }}
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-[#1A1A1A]">{{ $label }}</p>
                        @if(isset($application->timeline[$key]))
                            <p class="text-sm text-[#6D7A89]">{{ \Carbon\Carbon::parse($application->timeline[$key])->format('d.m.Y') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
        <p class="text-[#6D7A89]">Заявка на поступление еще не создана</p>
    </div>
@endif
