import React from "react";
import { createRoot } from "react-dom/client";
import { ChatWidget } from "./widgets/ChatWidget";
import { TimelineWidget } from "./widgets/TimelineWidget";

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
