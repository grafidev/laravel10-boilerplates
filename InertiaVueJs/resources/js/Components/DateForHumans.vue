<script setup>
import { computed } from 'vue';

const props = defineProps({ 
    date: String, 
    relative: { type: Boolean, default: false },
    time: { type: Boolean, default: true }
});


const formattedDate = computed(() => {
    if(props.relative) return dayjs(props.date).fromNow();

    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    
    if(props.time) {
        options['hour'] = 'numeric';
        options['minute'] = 'numeric';
    }

    return new Intl.DateTimeFormat('fr-FR', options).format(new Date(props.date));
});
</script>
<template>
    <time v-if="props.date" class="text-sm dark:text-white">{{ formattedDate }}</time>    
    <span v-else>---</span>
</template>