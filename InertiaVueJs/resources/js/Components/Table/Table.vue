<script setup>
defineProps({
    overflow: { type: Boolean, default: true }
});
</script>
<template>
    <div class="relative dark:[color-scheme:dark]" :class="{ 'overflow-x-auto': overflow }">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
            <slot />
        </table>
    </div>
</template>