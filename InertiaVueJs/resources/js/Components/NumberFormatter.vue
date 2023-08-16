<script setup>
import { computed } from 'vue';
const props = defineProps({
    locale: { type: String, default: 'fr-FR' },
    value: { type: [Number, String] },
    currency: {
        type: [String, Boolean],
        default: false,
    }
});

const formattedNumber = computed(() => {
    const options = props.currency ? {style: 'currency', currency: props.currency } : {};
    return new Intl.NumberFormat(props.locale, options).format(Number(props.value));
});
</script>

<template>
    <span class="font-bold">{{ formattedNumber }}</span>
</template>