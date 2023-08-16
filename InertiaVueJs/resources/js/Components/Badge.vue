<template>
    <span :class="className" class="select-none">
        <slot/>
    </span>
</template>
<script setup>
import { computed } from 'vue';

const props = defineProps({
    color: { type: String, default: 'info' },
});

const className = computed(() => {
    return {
        'info': 'bg-green-100 text-green-800 text-xs font-medium w-fit px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300',
        'success': 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300',
        'danger': 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-red-900/40 dark:text-red-300',
        'dark': 'bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300',
        'warning': 'bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300',
    }[props.color];
});
</script>

