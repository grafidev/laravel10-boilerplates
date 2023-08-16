<script setup>
const props = defineProps(['checkbox']);
</script>

<template>
    <td class="px-6 py-2 whitespace-nowrap dark:text-white">
        <slot />
    </td>
</template>
