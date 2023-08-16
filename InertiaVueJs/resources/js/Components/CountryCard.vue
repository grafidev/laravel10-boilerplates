<script setup>
import { Link } from '@inertiajs/vue3';
import CountryImage from './CountryImage.vue';
const props = defineProps({
    country: Object,
    href: String,
});
</script>

<template>
    <Link :href="props.href" class="dark:hover:border-green-500 p-4 dark:bg-gray-800 flex flex-col items-center gap-4 bg-white border dark:border-gray-700 rounded-lg">
        <CountryImage :country="props.country" />
        <span class="uppercase font-bold text-xs">{{ props.country.name }}</span>
    </Link>
</template>