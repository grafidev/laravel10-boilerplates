<script setup>
defineProps({ title: String });
</script>

<template>
    <nav class="flex flex-col breadcrumb" aria-label="Breadcrumb">
        <h1 class="text-sm mb-3 uppercase font-bold text-green-600 dark:text-green-400" v-if="title">{{ title }}</h1>
        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-1">
            <slot />
        </ol>
    </nav>
</template>