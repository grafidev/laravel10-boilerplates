<script setup>
import Label from '@/Components/Forms/Label.vue';
import { ref, computed } from 'vue';
const emit = defineEmits(['update:modelValue', 'change']);
const props = defineProps({
    name: String,
    multiple: { type: Boolean, default: false },
    label: { type: Boolean, default: true },
    required: { type: Boolean, default: false },
    type: { type: String },
});

const file = ref(null);

const onChange = event => {
    const value = props.multiple ? event.target.files : event.target.files[0];

    file.value = value;
    emit('change', value);
    emit('update:modelValue', value);
};

const accept = computed(() => {
    if(props.type == 'audio') return 'audio/mpeg, audio/wav, audio/webm, audio/ogg';
    if(props.type == 'image') return 'image/*';
});

const fileName = computed(() => {
    if(! props.multiple) return file.value?.name;

    if(file.value?.length > 0) {
        const plural = file.value?.length > 1 ? 's' : '';
        return file.value?.length + ` fichier${plural} sélectionné${plural}`;
    }
    
    return false;
});

const label = computed(() => props.multiple ? 'Sélect. fichiers' : 'Parcourir...');
</script>
<template>
    <div class="whitespace-nowrap flex flex-col w-full">
        <Label v-if="props.label && props.name" :required="props.required"><slot/></Label>

        <label :for="props.name" class="cursor-pointer form-input border border-gray-300 text-gray-900 sm:text-sm rounded-lg hover:ring-green-500 hover:border-green-500 hover:bg-white w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:hover:ring-green-500 dark:hover:border-green-500 items-center justify-center flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
            </svg>
            <span class="font-bold dark:text-white">
                <span>{{ fileName ? fileName : label }}</span>
            </span>
        </label>

        <input type="file" :accept="accept" @change="onChange" :id="props.name" :name="props.name" class="hidden" :multiple="props.multiple" :required="props.required">
    </div>
</template>