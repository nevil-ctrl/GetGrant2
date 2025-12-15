<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function student(Request $request)
    {
        $user = $request->user()->load('manager');

        $application = Application::query()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $timelineOrder = [
            'consultation' => 'Консультация',
            'documents' => 'Документы',
            'submission' => 'Подача заявки',
            'offer' => 'Оффер',
            'visa' => 'Виза',
            'departure' => 'Вылет',
        ];

        $timeline = collect($timelineOrder)->map(function ($label, $key) use ($application) {
            $timelineData = $application?->timeline ?? [];
            $status = $application?->status;
            $completedStages = [
                'consultation',
                'documents',
                'submission',
                'offer',
                'visa',
                'departure',
            ];

            $currentIndex = array_search($status, $completedStages, true);
            $stageIndex = array_search($key, $completedStages, true);

            return [
                'key' => $key,
                'label' => $label,
                'date' => $timelineData[$key] ?? null,
                'completed' => $currentIndex !== false && $stageIndex !== false
                    ? $stageIndex <= $currentIndex
                    : false,
            ];
        })->values()->all();

        $timelineProps = [
            'title' => 'Статус поступления',
            'items' => $timeline,
        ];

        $chatProps = [
            'userName' => $user->name,
            'managerName' => $user->manager?->name ?? 'Ваш менеджер',
            'messages' => [],
        ];

        return view('dashboards.student', compact(
            'user',
            'timelineProps',
            'chatProps',
            'application'
        ));
    }

    public function parent(Request $request)
    {
        $user = $request->user()->load('manager');
        return view('dashboards.parent', compact('user'));
    }

    public function manager(Request $request)
    {
        $user = $request->user();
        return view('dashboards.manager', compact('user'));
    }
}

