<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import { CreditCardIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    physical_card: Object,
});
</script>

<template>
    <DashboardLayout title="Informations sur la carte">
        <template #header>
            <DashboardBreadcrumb title="Clientèle et cartes">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.physical_cards.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <CreditCardIcon class="w-5 h-5 mr-2.5"/> Gestion clients et cartes
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Informations sur la carte {{ props.physical_card.data.serial_number }}</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>
    </DashboardLayout>
</template>