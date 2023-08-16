<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: String,
});
</script>

<template>
    <Link class="font-medium text-green-600 dark:text-green-500 hover:underline" :href="props.href"><slot/></Link>
</template>