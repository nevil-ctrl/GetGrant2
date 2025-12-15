import React from "react";

type TimelineItem = {
    key: string;
    label: string;
    date?: string | null;
    completed?: boolean;
};

type TimelineWidgetProps = {
    title?: string;
    items: TimelineItem[];
};

export function TimelineWidget({
    title = "Этапы поступления",
    items,
}: TimelineWidgetProps) {
    return (
        <div className="bg-white rounded-2xl border border-border/60 shadow-sm p-6 space-y-4">
            <div>
                <p className="text-sm font-semibold text-slate-900">{title}</p>
                <p className="text-xs text-slate-500">
                    Обновляется менеджером после каждого шага
                </p>
            </div>
            <div className="space-y-4">
                {items.map((item, index) => (
                    <div key={item.key} className="flex gap-4 items-start">
                        <div className="flex flex-col items-center">
                            <div
                                className={`w-3 h-3 rounded-full border-2 ${
                                    item.completed
                                        ? "bg-[#1055b2] border-[#1055b2]"
                                        : "border-slate-300"
                                }`}
                            ></div>
                            {index !== items.length - 1 && (
                                <div className="w-px flex-1 bg-slate-200 mt-1"></div>
                            )}
                        </div>
                        <div className="flex-1 pb-4 border-b border-dashed border-slate-200 last:border-0 last:pb-0">
                            <div className="flex items-center justify-between">
                                <p className="text-sm font-semibold text-slate-900">
                                    {item.label}
                                </p>
                                {item.date && (
                                    <span className="text-xs text-slate-500">
                                        {item.date}
                                    </span>
                                )}
                            </div>
                            <p className="text-xs text-slate-500 mt-1">
                                {item.completed
                                    ? "Завершено"
                                    : "В ожидании подтверждения"}
                            </p>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

