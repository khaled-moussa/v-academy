import { defineConfig } from "vite";
import { resolve } from "path";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // -- App
                "resources/css/app.css",
                "resources/js/app.js",

                // -- Errors
                "resources/css/pages/errors/_errors.css",

                // -- Landing
                "resources/css/pages/landing/_landing.css",
            ],
            refresh: true,
        }),

        tailwindcss(),
    ],

    build: {
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: "js/[name].js",
                chunkFileNames: "js/[name].[hash].js",
                assetFileNames: "assets/[name][extname]",
                dir: "public/build",
            },
        },
    },

    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },

    resolve: {
        alias: {
            "@": resolve(__dirname, "resources"),

            "@js": resolve(__dirname, "resources/js"),
            "@css": resolve(__dirname, "resources/css"),

            "@img": resolve(__dirname, "resources/assets/images"),
            "@videos": resolve(__dirname, "resources/assets/videos"),
            "@json": resolve(__dirname, "resources/json"),
            "@views": resolve(__dirname, "resources/views"),
        },
    },
});
