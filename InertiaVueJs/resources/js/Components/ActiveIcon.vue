<script setup>
const props = defineProps({
    active: Boolean|Number,
    label: { type: Boolean, default: true },
})
</script>

<template>
    <div class="flex items-center gap-2">
        <svg v-if="props.active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    
        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <span :class="[
            'text-sm',
            props.active ? 'text-green-400' : 'text-red-400'
        ]" v-if="props.label">{{ props.active ? 'Actif' : 'Inactif' }}</span>
    </div>
</template>