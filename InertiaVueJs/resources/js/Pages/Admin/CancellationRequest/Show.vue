<script setup>
const props = defineProps({
    cancellation_request: Object,
});
</script>

<template>
    <div>{{ props.cancellation_request }}</div>
</template>