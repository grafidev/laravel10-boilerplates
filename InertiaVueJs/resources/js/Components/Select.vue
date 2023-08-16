<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    emptySelection: { type: Boolean, default: true },
    placeholder: { type: String, default: '' },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="bg-white border mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
        :value="props.modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
    <option v-if="props.placeholder" value="" :disabled="!props.emptySelection">{{ props.placeholder }}</option>
    <slot/>
    </select>
</template>

