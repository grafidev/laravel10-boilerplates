<script setup>
import { ref } from 'vue';
const props = defineProps({ title: String })
const active = ref(true);
const toggleActive = () => {
    active.value = !active.value;
};
</script>

<template>
    <div>
        <li class="flex items-center justify-between cursor-pointer mb-2 select-none sidebar-group" @click.prevent="toggleActive">
            <span class="uppercase text-xs font-bold dark:text-green-400 text-green-600">{{ title }}</span>

            <svg v-if="active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>

            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </li>

        <slide-up-down v-model="active" :duration="200" class="space-y-1">
            <slot/>
        </slide-up-down>
    </div>
</template>