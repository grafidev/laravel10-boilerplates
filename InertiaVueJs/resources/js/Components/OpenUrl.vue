<script setup>
const props = defineProps({
    url: String,
});

const openUrl = () => {
    window.open(props.url, '_blank');
};
</script>

<template>
    <a href="#" class="text-green-600 underline" @click.prevent="openUrl"><slot/></a>
</template>