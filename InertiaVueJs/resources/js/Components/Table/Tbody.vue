<script setup>
const props = defineProps({
    animation: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        <slot />
    </tbody>
</template>
