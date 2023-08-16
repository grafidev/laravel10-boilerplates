<script setup>
const props = defineProps(['name', 'id', 'modelValue', 'value'])
defineEmits(['update:modelValue']);
</script>
<template>
    <div class="flex items-center mb-4">
        <input 
            @change="(event) => $emit('update:modelValue', event.target.value)"
            type="radio" 
            :id="id" 
            :name="name" 
            :value="value"
            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        >
        <label :for="id" class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><slot/></label>
    </div>
</template>