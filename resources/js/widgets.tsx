// resources/js/widgets.tsx
import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import { ChatWidget } from "./widgets/ChatWidget";
import { TimelineWidget } from "./widgets/TimelineWidget";
import { initPhoneInput } from "./widgets/phoneInput";


// Импорт CSS intl-tel-input один раз
import "intl-tel-input/build/css/intlTelInput.css";

document.addEventListener("DOMContentLoaded", () => {
    initPhoneInput(); // инициализация поля телефона

    const widgets: Record<string, React.ComponentType<any>> = {
        chat: ChatWidget,
        timeline: TimelineWidget,
    };

    document.querySelectorAll<HTMLElement>("[data-widget]").forEach((el) => {
        const name = el.dataset.widget;
        if (!name || !widgets[name]) return;

        const Component = widgets[name];

        let props: Record<string, unknown> = {};
        if (el.dataset.props) {
            try {
                props = JSON.parse(el.dataset.props);
            } catch (e) {
                console.error("Failed to parse widget props", e);
            }
        }

        const root = createRoot(el);
        root.render(
            React.createElement(
                React.StrictMode,
                null,
                React.createElement(Component, props)
            )
        );
    });
});
