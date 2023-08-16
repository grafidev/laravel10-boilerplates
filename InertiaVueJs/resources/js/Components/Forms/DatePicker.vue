<script setup>
import { ref, computed } from 'vue';
import flatPickr from 'vue-flatpickr-component';
import {French} from 'flatpickr/dist/l10n/fr.js';
import 'flatpickr/dist/flatpickr.css';

const props = defineProps({
    time: {
        type: Boolean,
        default: false,
    },
});

const format = computed(() => {
    return `Y-m-d${props.time ? ' H:i:s' : ''}`;
});

const config = ref({
    wrap: false, // set wrap to true only when using 'input-group'
    altFormat: format,
    altInput: true,
    dateFormat: format,
    locale: French, // locale for this instance only 
    enableTime: props.time,
});

</script>

<template>
    <flat-pickr 
        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" 
        :config="config"  
    />
</template>