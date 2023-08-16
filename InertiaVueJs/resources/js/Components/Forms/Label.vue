<script setup>
const props = defineProps({
    value: String,
    required: { type: Boolean, default: false },
});
</script>

<template>
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span class="text-red-700 font-bold px-1" v-if="props.required">*</span>
    </label>
</template>