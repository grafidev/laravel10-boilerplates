<script setup>
import { nextTick, ref, watch } from 'vue';

const sidebarWrapped = ref(localStorage.getItem('sidebar-wrapped') !== null);

const toggleSidebar = () => {
    sidebarWrapped.value = !sidebarWrapped.value;
};

watch(sidebarWrapped, value => {
    nextTick(() => {
        if(value) {
            localStorage.setItem('sidebar-wrapped', '1');
        } else {
            localStorage.removeItem('sidebar-wrapped');
        }
    
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        if(value) {
            sidebar?.classList?.remove('w-72');
            sidebar?.classList?.add('w-20');

            Array.from(document.querySelectorAll('.sidebar-item-text')).forEach(item => {
                item?.classList?.add('hidden');
            });

            Array.from(document.querySelectorAll('.sidebar-group')).forEach(item => {
                item?.classList?.add('hidden');
            });

            Array.from(document.querySelectorAll('.sidebar-item-link')).forEach(item => {
                item?.classList?.add('justify-center');
            });
            content?.classList?.remove('ml-72');
            content?.classList?.add('ml-20');
        } else {
            sidebar?.classList?.remove('w-20');
            sidebar?.classList?.add('w-72');
            Array.from(document.querySelectorAll('.sidebar-item-text')).forEach(item => {
                item?.classList?.remove('hidden');
            });
            Array.from(document.querySelectorAll('.sidebar-group')).forEach(item => {
                item?.classList?.remove('hidden');
            });
            Array.from(document.querySelectorAll('.sidebar-item-link')).forEach(item => {
                item?.classList?.remove('justify-center');
            });
            content?.classList?.remove('ml-20');
            content?.classList?.add('ml-72');
        }
    });
}, { immediate: true });
</script>
<template>
    <button @click.prevent="toggleSidebar" type="button" class="shrink-0 hidden lg:flex items-center justify-center w-10 h-10 text-green-500 rounded-full outline-none hover:bg-gray-500/5 focus:bg-green-500/10 mr-2 ml-1" x-bind:aria-label="$store.sidebar.isOpen ? 'Collapse sidebar' : 'Expand sidebar'" x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()" x-transition:enter="lg:transition delay-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" aria-label="Collapse sidebar">
        <svg v-if="!sidebarWrapped" class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.25 7.5L16 12L20.25 16.5M3.75 12H12M3.75 17.25H16M3.75 6.75H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>

        <svg v-else class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
        </svg>
    </button>
</template>