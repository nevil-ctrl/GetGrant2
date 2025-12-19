import React from "react";
import { createRoot } from "react-dom/client";
import { ChatWidget } from "./widgets/ChatWidget";
import { TimelineWidget } from "./widgets/TimelineWidget";

// Импортируем CSS и JS intl-tel-input
import "intl-tel-input/build/css/intlTelInput.css";
import { initPhoneInput } from "./widgets/phoneInput";

type WidgetMap = {
    [key: string]: React.ComponentType<any>;
};

const widgets: WidgetMap = {
    chat: ChatWidget,
    timeline: TimelineWidget,
};

document
    .querySelectorAll<HTMLElement>("[data-widget]")
    .forEach((el) => {
        const name = el.dataset.widget;
        if (!name || !widgets[name]) return;

        const root = createRoot(el);
        root.render(React.createElement(widgets[name]));
    });

// После рендера всех виджетов и загрузки DOM инициализируем телефонный input
document.addEventListener("DOMContentLoaded", () => {
    initPhoneInput();
});
