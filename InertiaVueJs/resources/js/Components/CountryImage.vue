<script setup>
import { isoToEmoji } from '@/utils';
const props = defineProps({
    country: Object,
});
</script>

<template>
    <span class="text-4xl" v-tippy="{ content: props.country.name }">{{ isoToEmoji(props.country.code.toLowerCase()) }}</span>
</template>