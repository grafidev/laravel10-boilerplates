<script setup>
import CloseButton from './CloseButton.vue';
const emit = defineEmits(['close']);
</script>

<template>
    <div class="px-4 py-3 border-b dark:border-gray-700 flex items-center justify-between dark:text-white">
        <h1 class="text-lg font-bold"><slot/></h1>

        <button type="button" @click.prevent="emit('close')" class="text-gray-400 bg-transparent hover:bg-green-100 hover:text-gray-900 rounded-full text-sm p-1 inline-flex items-center dark:hover:bg-green-800 dark:hover:text-white">
            <CloseButton class="w-3 h-3"/>
        </button>
    </div>
</template>