<script setup>
import TableLink from './TableLink.vue';
import { Tippy } from 'vue-tippy'

defineProps(['url']);

</script>

<template>
    <Tippy content="Voir">
        <TableLink @click.stop :href="url" class="items-center flex gap-2 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg> 
            <slot/>
        </TableLink>
    </Tippy>
</template>