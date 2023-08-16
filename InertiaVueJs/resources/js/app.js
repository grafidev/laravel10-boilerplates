import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import VueClickAway from 'vue3-click-away';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueSelect from 'vue-select';
import SlideUpDown from 'vue3-slide-up-down';
import VueTippy from 'vue-tippy';
import VueTelInput from 'vue-tel-input';
import VueApexCharts from "vue3-apexcharts";

import 'tippy.js/dist/tippy.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component('v-select', VueSelect)
            .component('slide-up-down', SlideUpDown)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueClickAway)
            .use(VueTelInput)
            .use(VueApexCharts)
            .use(VueTippy, {
                defaultProps: { placement: 'top' },
            })
            .mount(el);
    },
    progress: {
        color: '#0f766e',
    },
});
