import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
console.log("JS подключен!");
import { ChatWidget } from "./widgets/ChatWidget";
import { TimelineWidget } from "./widgets/TimelineWidget";
import { initPhoneInput } from "./widgets/phoneInput";

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

        let props: Record<string, unknown> = {};
        if (el.dataset.props) {
            try {
                props = JSON.parse(el.dataset.props);
            } catch (e) {
                console.error("Failed to parse widget props", e);
            }
        }

        const root = createRoot(el); // создаём root
        root.render(
            React.createElement(
                React.StrictMode,
                null,
                React.createElement(Component, props)
            )
        );
    });
});
