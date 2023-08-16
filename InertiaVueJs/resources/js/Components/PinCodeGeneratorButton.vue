<script setup>
import { generateRandomDigits } from '@/utils';
import { Cog6ToothIcon } from '@heroicons/vue/24/outline';
const emit = defineEmits(['onGenerate']);
const props = defineProps({
    length: Number,
});

const generate = () => {
    emit('onGenerate', generateRandomDigits(props.length));
};
</script>

<template>
    <button type="button" @click.prevent="generate">
        <Cog6ToothIcon class="w-4 h-4" />
    </button>
</template>