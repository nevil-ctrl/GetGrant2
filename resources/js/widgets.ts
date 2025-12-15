import "./bootstrap";
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

const mountWidgets = () => {
    document
        .querySelectorAll<HTMLElement>("[data-widget]")
        .forEach((element) => {
            const widgetName = element.dataset.widget;
            if (!widgetName) {
                return;
            }

            const Component = widgets[widgetName];
            if (!Component) {
                console.warn(`Widget "${widgetName}" is not registered`);
                return;
            }

            let props: Record<string, unknown> = {};
            if (element.dataset.props) {
                try {
                    props = JSON.parse(element.dataset.props);
                } catch (error) {
                    console.error("Failed to parse widget props", error);
                }
            }

            const root = createRoot(element);
            root.render(
                <React.StrictMode>
                    <Component {...props} />
                </React.StrictMode>
            );
        });
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", mountWidgets, {
        once: true,
    });
} else {
    mountWidgets();
}

