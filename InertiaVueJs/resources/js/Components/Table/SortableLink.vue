<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
const props = defineProps(['label', 'attribute']);

const sort = computed(() => {
    let url = new URL(document.location);
    return url.searchParams.get('sort');
});

const sortLink = computed(() => {
    let url = new URL(document.location);
    let sortValue = url.searchParams.get('sort');

    if(sortValue == props.attribute) {
        url.searchParams.set('sort', '-' + props.attribute);
    } else if(sortValue == '-' + props.attribute) {
        url.searchParams.set('sort', props.attribute);
    } else {
        url.searchParams.set('sort', props.attribute);
    }
    return url.href;
});
</script>
<template>
    <Link :href="sortLink" class="flex items-center gap-2" :preserve-scroll="true">
        {{ label }}
        <div v-if="sort == attribute">&uarr;</div>
        <div v-else>&darr;</div>
    </Link>
</template>