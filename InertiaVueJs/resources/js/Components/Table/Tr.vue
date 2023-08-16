<script setup>
import { router } from '@inertiajs/vue3';
const props = defineProps({
    url: { type: String, default: null },
    hover: { type: Boolean, default: true }
});

const visitUrl = event => {
    if(props.url !== null) {
        event.preventDefault();
        router.visit(props.url);
    }
};
</script>

<template>
    <tr @click="visitUrl" :class="[
        props.hover ? 'hover:bg-gray-50 dark:hover:bg-gray-700' : '',
        'bg-white  dark:bg-gray-800 dark:text-white',
        props.url ? 'cursor-pointer' : ''
    ]">
        <slot />        
    </tr>
</template>