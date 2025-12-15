import React, { useState } from "react";

type Message = {
    id: number;
    author: "manager" | "student";
    text: string;
    timestamp: string;
};

type ChatWidgetProps = {
    userName: string;
    managerName: string;
    messages?: Message[];
};

export function ChatWidget({
    userName,
    managerName,
    messages = [],
}: ChatWidgetProps) {
    const [draft, setDraft] = useState("");
    const [localMessages, setLocalMessages] = useState(messages);

    const sendMessage = () => {
        if (!draft.trim()) {
            return;
        }

        const newMessage: Message = {
            id: Date.now(),
            author: "student",
            text: draft.trim(),
            timestamp: new Date().toISOString(),
        };

        setLocalMessages([...localMessages, newMessage]);
        setDraft("");
    };

    return (
        <div className="flex flex-col h-full bg-white rounded-2xl border border-border/60 shadow-sm overflow-hidden">
            <header className="border-b border-border/60 px-4 py-3">
                <p className="text-xs text-slate-500">Менеджер</p>
                <p className="text-sm font-semibold text-slate-900">
                    {managerName}
                </p>
            </header>

            <div className="flex-1 space-y-3 p-4 overflow-y-auto bg-slate-50/60">
                {localMessages.length === 0 && (
                    <p className="text-xs text-slate-500">
                        Напишите {managerName}, чтобы начать диалог.
                    </p>
                )}
                {localMessages.map((message) => (
                    <div
                        key={message.id}
                        className={`flex ${
                            message.author === "student"
                                ? "justify-end"
                                : "justify-start"
                        }`}
                    >
                        <div
                            className={`px-4 py-2 rounded-2xl text-sm max-w-[70%] ${
                                message.author === "student"
                                    ? "bg-[#1055b2] text-white rounded-br-none"
                                    : "bg-white border border-border/60 text-slate-900 rounded-bl-none"
                            }`}
                        >
                            <div className="text-xs opacity-80 mb-1">
                                {message.author === "student"
                                    ? userName
                                    : managerName}
                            </div>
                            <p>{message.text}</p>
                        </div>
                    </div>
                ))}
            </div>

            <div className="border-t border-border/60 p-3 bg-white">
                <textarea
                    className="w-full rounded-xl border border-border px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#1055b2] h-20"
                    placeholder="Введите сообщение"
                    value={draft}
                    onChange={(event) => setDraft(event.target.value)}
                />
                <button
                    className="mt-2 w-full rounded-xl bg-[#1055b2] text-white py-2 text-sm font-semibold hover:bg-[#003b8a] transition-colors"
                    onClick={sendMessage}
                >
                    Отправить
                </button>
            </div>
        </div>
    );
}

