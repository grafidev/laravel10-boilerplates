<script setup>
import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';
import { onMounted } from 'vue';
import SecondaryButton from '../SecondaryButton.vue';

const emit = defineEmits(['change:left', 'change:right', 'submit']);

const props = defineProps({
    id: String,
    min: { type: Number, default: 0 },
    max: { type: Number, default: 0 },
});

onMounted(() => {
    const slider = document.getElementById(props.id);

    noUiSlider.create(slider, {
        start: [props.min, props.max],
        connect: true,
        range: { 'min': props.min, 'max': props.max },
        step: 10,
    });

    slider.noUiSlider.on('update', function (values, handle) {
        emit(handle ? 'change:right' : 'change:left', values[handle]);
    });
});
const submit = () => emit('submit');
</script>

<template>
    <div :id="props.id"></div>

    <div class="mt-4 flex items-center justify-center">
        <SecondaryButton @click.prevent="submit">Rechercher</SecondaryButton>
    </div>
</template>

<style>
.noUi-connect { @apply bg-green-600; }
.noUi-touch-area {@apply cursor-pointer;}

.noUi-connects {
    @apply dark:bg-gray-700 border-gray-500;
}
.noUi-target {
    @apply dark:border-gray-600;
}
</style>