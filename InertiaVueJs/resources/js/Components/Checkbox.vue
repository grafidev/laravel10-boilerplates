<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);
const props = defineProps(['checked', 'modelValue', 'label', 'fieldId']);

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <div class="flex items-center gap-3">
        <input
            type="checkbox"
            :id="fieldId"
            :value="modelValue"
            v-model="proxyChecked"
            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <label :for="fieldId"><slot/></label>
    </div>
</template>
    

