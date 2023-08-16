<script setup>
import TabLink from '@/Components/Navigation/TabLink.vue';
import { usePage } from '@inertiajs/vue3';
const { auth } = usePage().props;
</script>
<template>
    <div class="p-3 bg-white dark:bg-gray-800">
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 overflow-hidden">
            <ul class="flex overflow-x-auto scroll-m-0">
                <li class="whitespace-nowrap">
                    <TabLink :href="route('dashboard.roles.index')" :active="route().current('dashboard.roles.index')">Gestion des roles</TabLink>
                </li>

                <li class="whitespace-nowrap">
                    <TabLink :href="route('dashboard.permissions.index')" :active="route().current('dashboard.permissions.index')">Gestion des permissions</TabLink>
                </li>
            </ul>
        </div>
    </div>
</template>