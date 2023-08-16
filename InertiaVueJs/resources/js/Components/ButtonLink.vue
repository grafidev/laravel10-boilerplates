<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: String,
    outline: { type: Boolean, default: false },
    variant: { type: String, default: 'default' },
})

const className = computed(() => {
    if(props.variant == 'blue') return 'text-green-600 dark:text-green-500';
    if(props.variant == 'default') return 'text-green-600 dark:text-green-500';
    if(props.variant == 'red') return 'text-red-600 dark:text-red-500';
});

</script>

<template>
    <Link :href="props.href" :class="[
        className,
        'font-medium hover:underline'
    ]">
        <slot/>
    </Link>
</template>
