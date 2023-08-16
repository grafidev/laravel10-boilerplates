<script setup>
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardNavbar from '@/Components/DashboardNavbar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';
import Spotlight from '@/Components/Spotlight.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useRole } from '@/composables';
import Alert from '@/Components/Alert.vue';

const { isSuperAdmin, isAdmin, isUser } = useRole();

const props = defineProps({ title: String });
const showSpotlight = ref(false);
const animate = ref(false);

const openSpotlight = (e) => {
    if (e.key === 'k' && (e.ctrlKey === true || e.metaKey === true) && !showSpotlight.value) {
        showSpotlight.value = true;
    }
};

const currentUrl = computed(() => usePage().url);

onMounted(() => {
    document.addEventListener('keydown', openSpotlight);
    animate.value = true;
});
onUnmounted(() => {
    document.removeEventListener('keydown', openSpotlight);
});
</script>

<template>
    <Head :title="title" />

    <DashboardNavbar />
    
    <DashboardSidebar />
    
    <div class="p-4 px-2 ml-72 flex flex-col transition-all h-screen" id="content">
        <div class="pt-12 flex-1 mb-5">
            <Alert key="success" v-if="$page.props.flash.success" @close="$page.props.flash.success = null" variant="success">{{ $page.props.flash.success }}</Alert>
            <Alert key="danger" v-if="$page.props.flash.danger" @close="$page.props.flash.danger = null" variant="danger">{{ $page.props.flash.danger }}</Alert>
            <Alert key="info" v-if="$page.props.flash.info" @close="$page.props.flash.info = null" variant="info">{{ $page.props.flash.info }}</Alert>
            <Alert key="warning" v-if="$page.props.flash.warning" @close="$page.props.flash.warning = null" variant="warning">{{ $page.props.flash.warning }}</Alert>
            
            <header class="bg-white dark:bg-gray-800 border dark:border-gray-700 shadow px-3 mt-2 mb-2" v-if="$slots.header">
                <div class="max-w-8xl mx-auto py-3 px-2 sm:px-6 lg:px-2 flex items-center space-x-2 rounded-lg">
                    <div class="flex items-end justify-between w-full">
                        <slot name="header" />
                        <slot name="actions" />
                    </div>
                </div>
            </header>


            <main v-if="animate" class="dark:[color-scheme:dark] h-full">
                <slot />
            </main>

                
            <Spotlight placeholder="Rechercher un lien" :show="showSpotlight" @close="showSpotlight = false"/>

            <Link v-if="false && !currentUrl.includes('/settings')" :href="route('dashboard.settings.create')" class="fixed bottom-8 bg-green-200 hover:bg-green-300 right-4 dark:bg-green-700/40 dark:hover:bg-green-700/100 w-12 h-12 flex items-center justify-center z-50 rounded-full">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400/40 opacity-75"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </Link>
        </div>
        <DashboardFooter />
    </div>
</template>

<style>
@import "tippy.js/dist/tippy.css";
@import 'vue-select/dist/vue-select.css';

.page-enter-active,
.page-leave-active {
    transition: all .1s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}
</style>