<script setup>
import Card from '@/Components/Card.vue';
</script>

<template>
    <Card class="flex items-center justify-center flex-col space-y-7 py-20">
        <span class="w-20 h-20 bg-green-50 dark:bg-green-700/30 flex items-center justify-center rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-green-600">
                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
            </svg>
        </span>
        <h3 class="text-2xl"><slot/></h3>
    </Card>
</template>