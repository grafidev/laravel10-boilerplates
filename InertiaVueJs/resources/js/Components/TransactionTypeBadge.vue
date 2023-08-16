<script setup>
import { computed } from 'vue';
import Badge from '@/Components/Badge.vue';
const props = defineProps({
    name: String,
});

const color = computed(() => {
    const colorsConfig = {
        'Annulation': 'danger',
        'Achat': 'success',
        'Recharge': 'info',
        'bon de carburant': 'warning',
    };
    return colorsConfig[props.name] || 'dark';
});
</script>
<template>
    <Badge :color="color"><slot/></Badge>
</template>