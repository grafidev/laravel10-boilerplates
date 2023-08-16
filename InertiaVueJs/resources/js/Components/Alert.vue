<script setup>
import { CheckCircleIcon, ExclamationCircleIcon, InformationCircleIcon, ShieldExclamationIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const emit = defineEmits(['close']);
const props = defineProps({
    heading: String,
    variant: { type: String, default: 'success' },
});

const active = ref(true);

const close = () => emit('close');
</script>

<template>
    <div class="rounded-md p-4 mt-2 flex items-center"
        :class="[
            props.variant === 'success' ? 'bg-green-50 dark:bg-green-700/50 border-green-300 dark:border-green-700 border text-green-600 dark:text-green-200' : '',
            props.variant === 'info' ? 'bg-green-50 dark:bg-green-700/50 border-green-600 dark:border-green-200 border text-green-600 dark:text-green-200' : '',
            props.variant === 'danger' ? 'bg-red-50 dark:bg-red-700/50 border-red-600 dark:border-red-200 border text-red-600 dark:text-red-200' : '',
            props.variant === 'warning' ? 'bg-yellow-50 dark:bg-yellow-700/50 border-yellow-600 dark:border-yellow-200 border text-yellow-600 dark:text-yellow-200' : '',
        ]"
    >
        <p class="flex items-center text-sm font-medium">
            <span class="pr-3">
                <InformationCircleIcon v-if="props.variant === 'info'" class="flex-shrink-0 w-5 h-5"/>
                <CheckCircleIcon v-if="props.variant === 'success'" class="flex-shrink-0 w-5 h-5"/>
                <ShieldExclamationIcon v-if="props.variant === 'danger'" class="flex-shrink-0 w-5 h-5"/>
                <ExclamationCircleIcon v-if="props.variant === 'warning'" class="flex-shrink-0 w-5 h-5"/>
            </span>

        </p>
        <slot />

        <button class="ml-auto text-inherit" @click.prevent="close">
            <XMarkIcon class="w-5 h-5" />
        </button>
    </div>
</template>

