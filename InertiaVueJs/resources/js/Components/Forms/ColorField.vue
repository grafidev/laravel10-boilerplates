<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps({
    modelValue: {
        type: [String, Number, Object],
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const val1 = ref('');
</script>

<template>
    <input
        type="color"
        class="w-full h-[40px] border-none"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
