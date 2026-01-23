@if(isset($student) && isset($application))
    @include('dashboards.includes.student-application', ['application' => $application])
@else
    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
        <p class="text-[#6D7A89]">Информация о поступлении недоступна</p>
    </div>
@endif
