<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: { type: String, default: false },
});
</script>
<template>
    <Link class="dark:hover:border-green-500" v-if="props.href!=''" :href="props.href"><slot/></Link>
    <div v-else><slot/></div>
</template>