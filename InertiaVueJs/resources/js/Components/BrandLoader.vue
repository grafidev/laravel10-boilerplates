<script setup>
import ApplicationLogo from './ApplicationLogo.vue';
import Loader from './Loader.vue';
const props = defineProps({
    loading: { type: Boolean, default: false },
});
</script>
<template>
    <Loader :loading="props.loading">
        <template #logo>
            <ApplicationLogo class="text-white"/>
        </template>
    </Loader>
</template>