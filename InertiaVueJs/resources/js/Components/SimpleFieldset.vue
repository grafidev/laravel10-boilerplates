<script setup>
const props = defineProps({
    title: String,
    cols: { type: [String, Number], default: 2 }
});
</script>

<template>
    <fieldset class="space-y-3 border dark:border-gray-700 p-2 w-full">
        <legend class="text-sm">{{ props.title }}</legend>
        <div :class="[
            `grid grid-cols-${props.cols} gap-2`,
        ]">
            <slot/>
        </div>
    </fieldset>
</template>