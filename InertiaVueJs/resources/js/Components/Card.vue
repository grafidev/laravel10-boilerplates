<script setup>
import Linkable from './Linkable.vue';
const props = defineProps({
    title: String,
    href: { type: String, default: '' },
});
</script>

<template>
    <Linkable :href="props.href" class="p-4 bg-white shadow-lg sm:rounded-lg dark:bg-gray-800">
        <slot/>
    </Linkable>
</template>
