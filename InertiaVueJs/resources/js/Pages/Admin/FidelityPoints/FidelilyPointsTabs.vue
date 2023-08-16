<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    corporateClient: Object,
});
</script>

<template>
    <div class="border bg-white dark:bg-gray-800 rounded-md dark:border-gray-700 overflow-hidden">
        <div class="flex overflow-x-auto scroll-m-0 border-b dark:border-gray-600">
            <Link
                :href="route('dashboard.fidelity_points.index')"
                :class="[
                    'cursor-pointer py-4 px-8 bg-white dark:bg-gray-900 whitespace-nowrap dark:text-white hover:bg-green-100',
                    route().current('dashboard.fidelity_points.index') ? 'text-green-700 !bg-green-100 dark:text-white dark:!bg-green-800' : '',
                ]"
            >
                Points de fidélité
            </Link>

            <Link
                :href="route('dashboard.corporate_client_card_holders.index')"
                :class="[
                    'cursor-pointer py-4 px-8 bg-white dark:bg-gray-900 whitespace-nowrap dark:text-white hover:bg-green-100',
                    route().current('dashboard.corporate_client_card_holders.index') ? 'text-green-700 !bg-green-100 dark:text-white dark:!bg-green-800' : '',
                ]"
            >
                Porteurs de carte
            </Link>
        </div>
        
        <div class="p-[10px]">
            <slot />
        </div>
    </div>
</template>