<script setup>
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    user: Object,
});
</script>

<template>
    <div class="flex flex-col items-start" v-if="props.user">
        <span>{{ props.user?.name }}</span>
        <Badge v-for="role in props.user.roles" :key="role.id">{{ role.description }}</Badge>
    </div>
    <span v-else>---</span>
</template>