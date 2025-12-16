import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import path from "path";

const devHost = process.env.VITE_DEV_HOST ?? "localhost";
const devPort = Number(process.env.VITE_DEV_PORT ?? 5173);

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/widgets.tsx"],
            refresh: true,
        }),
        react({ fastRefresh: false }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
        },
    },
    server: {
        host: devHost,
        port: devPort,
        hmr: {
            host: devHost,
            port: devPort,
        },
    },
});
