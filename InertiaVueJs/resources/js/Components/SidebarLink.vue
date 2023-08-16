<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    title: String,
    href: String,
    active: { type: Boolean, default: false },
});
</script>
<template>
    <li>
        <Link
            preserve-scroll
            :href="props.href"
            :class="{'bg-green-100 dark:bg-green-700 dark:hover:bg-green-600 dark:text-white': props.active}"
            class="sidebar-item-link flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-green-100 group dark:text-gray-200 dark:hover:bg-gray-700"
        >
            <span v-if="$slots.icon">
                <slot name="icon" />
            </span>

            <span class="ml-3 text-sm sidebar-item-text">{{ props.title }}</span>
            <span v-if="$slots.notification" class="inline-flex items-center text-center justify-center rounded-full ml-4 text-white !bg-green-600 font-extrabold w-6 h-6 text-xs">
                <slot name="notification"/>
            </span>
        </Link>
    </li>
</template>