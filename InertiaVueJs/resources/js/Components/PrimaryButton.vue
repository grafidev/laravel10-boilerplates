<script setup>
const props = defineProps({
    type: { type: String, default: 'submit' },
    color: { type: String, default: 'primary' },
    disabled: { type: Boolean, default: false },
});
</script>

<template>
    <button
        :disabled="props.disabled"
        :type="props.type"
        class="inline-flex items-center px-4 py-2 bg-green-500 text-white border border-green-300 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-40 transition ease-in-out duration-150 dark:bg-green-700 dark:text-white dark:border-green-600 dark:hover:bg-green-600 !justify-center"
        :class="[
            props.disabled ? 'cursor-not-allowed' : ''
        ]"
    >
        <slot />
    </button>
</template>
