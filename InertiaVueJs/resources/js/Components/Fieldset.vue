<script setup>
import { ref } from 'vue';
const props = defineProps({
    title: String,
    active: { type: Boolean, default: true },
    toggleable: { type: Boolean, default: true },
    borderless: { type: Boolean, default: false },
});

const active = ref(props.active);

function toggleActive() {
    if(props.toggleable) {
        active.value = !active.value;
    }
}
</script>

<template>
    <fieldset :class="{ 'border': active, '!border-none !p-0': props.borderless }" class="px-3 py-4 rounded-sm dark:text-white dark:border-gray-700">
        <legend @click="toggleActive" class="font-bold flex items-center justify-between text-green-500 dark:text-green-400 uppercase text-xs p-2 border border-green-400 gap-3 select-none" :class="{ 'cursor-pointer': toggleable, 'mb-2': props.borderless }">
            {{ title }}

            <div v-if="toggleable">
                <svg v-if="active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </div>
        </legend>
        <div v-if="active">
            <slot />
        </div>
    </fieldset>
</template>