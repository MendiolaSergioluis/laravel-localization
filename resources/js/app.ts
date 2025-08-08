import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import __ from './lang';

// Get the app name from environment or use 'Laravel' as default
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Create the Inertia.js application
createInertiaApp({
    // Set the document title for each page
    title: (title) => `${title} - ${appName}`,

    // Dynamically resolve Vue page components based on route
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),

    // Setup function to initialize the Vue app
    setup({ el, App, props, plugin }) {
        // Create the Vue app instance
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)      // Use Inertia plugin
            .use(ZiggyVue);   // Use Ziggy for route helpers

        // Register the translation function globally as __
        app.config.globalProperties.__ = __;

        // Mount the app to the DOM
        app.mount(el);
    },

    // Configure the progress bar color for Inertia navigation
    progress: {
        color: '#4B5563',
    },
});
