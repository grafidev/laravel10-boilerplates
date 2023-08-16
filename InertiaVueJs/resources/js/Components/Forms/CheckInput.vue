<script setup>
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: [String, Number, Boolean],
});
</script>

<template>
    <input 
        :checked="modelValue"
        @change="emit('update:modelValue', $event.target.checked)"
        type="checkbox" 
        class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-green-300 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
    >
</template>