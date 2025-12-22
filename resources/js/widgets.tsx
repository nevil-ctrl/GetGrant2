import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import { ChatWidget } from "./widgets/ChatWidget";
import { TimelineWidget } from "./widgets/TimelineWidget";
import { initPhoneInput } from "./widgets/phoneInput";

import "intl-tel-input/build/css/intlTelInput.css";

document.addEventListener("DOMContentLoaded", () => {
    initPhoneInput();

    const widgets: Record<string, React.ComponentType<any>> = {
        chat: ChatWidget,
        timeline: TimelineWidget,
    };

    document.querySelectorAll<HTMLElement>("[data-widget]").forEach((el) => {
        const name = el.dataset.widget;
        if (!name || !widgets[name]) return;

        const Component = widgets[name];
        const root = createRoot(el);
        root.render(
            <React.StrictMode>
                <Component />
            </React.StrictMode>
        );
    });
});
