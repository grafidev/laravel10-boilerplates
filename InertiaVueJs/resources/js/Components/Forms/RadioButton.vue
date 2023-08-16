<script setup>
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: [String, Boolean],
    name: String,
    value: { type: String, default: null },
    required: { type: Boolean, default: false },
    checked: { type: Boolean, default: false },
});
const onChange = (e) => {
    const value = props.value !== null ? props.value : e.target.checked;
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="flex items-center gap-1">
        <label class="select-none gap-3 flex items-center cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
            <input 
                type="radio" 
                :value="props.value" 
                @change="onChange($event)"
                :checked="modelValue == props.value"
                :name="props.name" 
                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                :required="props.required"
            >
            <slot />
        </label>
    </div>
</template>