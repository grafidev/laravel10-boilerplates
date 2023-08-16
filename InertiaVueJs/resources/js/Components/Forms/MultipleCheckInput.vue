<script setup>
import { computed, ref } from "vue";

const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    label: String,
    id: { type: [String, Number] },
    value: { type: [String, Number] },
    modelValue: { type: [String, Number, Array] },
});

const items = ref([]);

const isChecked = computed(() => props.modelValue.includes(props.value));

const handleChange = event => {
    const checked = event.target.checked;
    const value = props.value;
    items.value = [...props.modelValue];

    if(checked) {
        items.value.push(value);
    } else {
        items.value = items.value.filter(item => item != value);
    }

    emit('update:modelValue', items.value);
};

</script>

<template>
    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            :id="props.id"
            :value="props.value"
            @change="handleChange"
            :checked="isChecked"
            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />

        <label :for="props.id" class="text-sm">
            <slot />
        </label>
    </div>
</template>