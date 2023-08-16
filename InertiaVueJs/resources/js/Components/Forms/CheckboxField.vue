<script setup>
import { ref } from 'vue';
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    value: [String, Number],
    id: String, 
    name: String,
    multiple: { type: Boolean, default: false },
    modelValue: Array,
});

const items = ref([]);

const onChange = event => {
    if(! items.value.includes(event.target.value)) {
        items.value.push(event.target.value);
    }

    emit('update:modelValue', items.value);
};
</script>

<template>
    <div class="flex items-center gap-3">
        <input
            type="checkbox"
            :id="props.id"
            :value="props.value"
            :multiple="props.multiple"
            :name="props.name"
            @change="onChange"
            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <label :for="props.id"><slot/></label>
    </div>
</template>