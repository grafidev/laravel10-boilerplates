<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: String,
    active: { type: Boolean, default: false },
});
</script>
<template>
    <Link
        :href="props.href"
        :class="[
            'cursor-pointer py-4 px-8 bg-white dark:bg-gray-800 whitespace-nowrap dark:text-white hover:bg-green-100 rounded-lg',
            props.active ? 'text-green-700 !bg-green-100 dark:text-white dark:!bg-green-800 font-bold' : '',
        ]"
    >
        <slot />
    </Link>
</template>