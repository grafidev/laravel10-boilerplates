<script setup>
import { Link } from '@inertiajs/vue3';
defineProps(['href']);
</script>
<template>
    <Link :href="href" class="font-medium text-green-600 dark:text-green-500 hover:underline"><slot/></Link>
</template>