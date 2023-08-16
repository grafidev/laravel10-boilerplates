<script setup>
const props = defineProps({
    title: String,
    titleCentered: { type: Boolean, default: false },
    shadow: { type: Boolean, default: true },
})
</script>

<template>
    <div :class="[
        props.shadow ? 'shadow border' : '',
        'p-2 sm:p-5 bg-white sm:rounded-lg  dark:bg-gray-800 dark:border-gray-700',
    ]">
        <header :class="[
            'mb-6 dark:text-white flex items-center',
            props.titleCentered ? 'justify-center' : ''
        ]">
            <h2 v-if="props.title" class="text-sm text-gray-900 dark:text-inherit font-extrabold">{{ props.title }}</h2>
            <div class="ml-auto" v-if="$slots.actions"><slot name="actions" /></div>
        </header>
        <slot />
    </div>
</template>