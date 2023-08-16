<script setup>
import { computed } from 'vue';
import Label from './Label.vue';

const emit = defineEmits(['update:modelValue', 'change']);
const props = defineProps({
    id: { type: String, required: true },
    name: { type: String, required: true },
    value: { type: String, required: true },
    chosenValue: { type: String, required: true },
    modelValue: [String, Number],
    required: { type: Boolean, default: false },
});

const checkedValue = computed(() => props.value == props.chosenValue);

const handleChange = (event) => {
    emit('change', event.target.value);
}
</script>
<template>
    <div class="flex items-center">
        <input 
            type="radio" 
            :name="props.name"
            :id="props.id"
            :value="props.value"
            :checked="checkedValue"
            @change="handleChange"
            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        >
        <label :for="props.id" class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" :required="props.required">
            <slot />
        </label>
    </div>
</template>