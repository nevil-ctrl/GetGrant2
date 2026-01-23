@if(isset($student))
    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
        <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Информация о ребенке</h2>
        <div class="space-y-3">
            <div>
                <p class="text-sm text-[#6D7A89]">Имя</p>
                <p class="text-lg font-semibold text-[#1A1A1A]">{{ $student->name }}</p>
            </div>
            <div>
                <p class="text-sm text-[#6D7A89]">Email</p>
                <p class="text-lg font-semibold text-[#1A1A1A]">{{ $student->email }}</p>
            </div>
            @if($student->manager)
                <div>
                    <p class="text-sm text-[#6D7A89]">Менеджер</p>
                    <p class="text-lg font-semibold text-[#1A1A1A]">{{ $student->manager->name }}</p>
                </div>
            @endif
        </div>
    </div>

    @if(isset($assignments) && $assignments->count() > 0)
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6 mt-6">
            <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Задания ребенка</h2>
            <div class="space-y-3">
                @foreach($assignments->take(5) as $assignment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-[#1A1A1A]">{{ $assignment->title }}</p>
                            <p class="text-xs text-[#6D7A89]">
                                @if($assignment->status === 'approved') Одобрено
                                @elseif($assignment->status === 'submitted') На проверке
                                @elseif($assignment->status === 'rejected') Отклонено
                                @else Ожидает
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
        <p class="text-[#6D7A89]">Ребенок не привязан к вашему аккаунту. Обратитесь к администратору.</p>
    </div>
@endif
