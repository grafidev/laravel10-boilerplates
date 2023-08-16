<script setup>
import ModalHeader from './ModalHeader.vue';
const emit  = defineEmits(['close']);
const props = defineProps({ title: { type: String, default: null } });
</script>

<template>
    <ModalHeader v-if="props.title" @close="emit('close')">{{ props.title }}</ModalHeader>

    <div class="px-4 py-3 mb-3">
        <slot />
    </div>
</template>
