<script setup>
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    user: Object,
});
</script>

<template>
    <div class="flex flex-col items-center">
        <span>{{ props.user?.name }}</span>
        <Badge>{{ props.user?.role?.description }}</Badge>
    </div>
</template>