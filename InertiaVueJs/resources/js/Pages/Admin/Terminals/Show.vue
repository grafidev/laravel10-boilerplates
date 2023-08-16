<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Card from '@/Components/Card.vue';
import { Link, usePage } from '@inertiajs/vue3';

const { auth } = usePage().props;
const props = defineProps({
    terminal: Object,
});
</script>

<template>
    <DashboardLayout title="Informations du terminal">
        <template #header>
            <DashboardBreadcrumb title="Informations du terminal">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.terminals.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        Terminaux
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ terminal.data.name }}</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>

        <Card>
            <pre>
                {{  JSON.stringify(terminal.data, null, 2) }}
            </pre>
        </Card>
    </DashboardLayout>
</template>