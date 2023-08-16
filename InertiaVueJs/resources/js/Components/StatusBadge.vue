<script setup>
import { computed } from 'vue';
import Badge from '@/Components/Badge.vue';
const props = defineProps({
    name: String,
});

const color = computed(() => {
    const colorsConfig = {
        'VALIDATION_DIRECTEUR_COMMERCIAL': 'info',
        'VALIDATION_DIRECTEUR_FINANCIER': 'warning',
        'VALIDEE': 'success',
        'REJETEE': 'danger',
        'INITIEE': 'info',
    };
    return colorsConfig[props.name] || 'dark';
});
</script>
<template>
    <Badge :color="color"><slot/></Badge>
</template>