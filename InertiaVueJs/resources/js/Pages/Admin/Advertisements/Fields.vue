<script setup>
import { computed } from 'vue'; 
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import Select from '@/Components/Select.vue';
import FileUpload from '@/Components/Forms/FileUpload.vue';
import RadioField from '@/Components/Forms/RadioField.vue';

const props = defineProps({
    form: Object,
});

const fileLabel = computed(() => {
    return {'image': 'Choisir une image', 'audio': 'Choisir une audio'}[props.form.type] || null;
});

const publicationTypes = [
    {label: 'Image', value: 'image'},
    {label: 'Audio', value: 'audio'},
    {label: 'Texte', value: 'text'},
];
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="title" required>Titre</Label>
            <TextField type="text" name="title" id="title" v-model="form.title" required/>
            <InputError class="mt-2" :message="form.errors.title"/>
        </div>

        <div class="col-span-full">
            <Label for="description" required>Description</Label>
            <TextareaField name="description" id="description" v-model="form.description" required/>
            <InputError class="mt-2" :message="form.errors.description"/>
        </div>

        <div class="col-span-full">
            <Label for="type" required>Sélectionner le type</Label>
            <div class="grid grid-cols-1 gap-4 mt-4">
                <RadioField 
                    name="type" 
                    :id="publicationType.value" 
                    :value="publicationType.value" 
                    :chosen-value="publicationType.value" 
                    @change="value => form.type = value" 
                    :key="publicationType.value" 
                    v-for="publicationType in publicationTypes"
                >
                    {{ publicationType.label }}
                </RadioField>
            </div>
            <InputError class="mt-2" :message="form.errors.type"/>
        </div>

        <div class="col-span-full" v-if="form.type == 'text'">
            <Label for="content">Texte</Label>
            <TextareaField v-model="form.content" name="content" id="content"/>
        </div>

        <div class="col-span-full" v-if="fileLabel">
            <FileUpload name="file" v-model="form.file" :type="form.type">{{ fileLabel }}</FileUpload>
            <InputError class="mt-2" :message="form.errors.file" />
        </div>
        
        <div>
            <Label for="start_date" required>Date de début</Label>
            <DatePicker v-model="form.start_date" required />
            <InputError class="mt-2" :message="form.errors.start_date" />
        </div>

        <div>
            <Label for="end_date" required>Date de fin</Label>
            <DatePicker v-model="form.end_date" required />
            <InputError class="mt-2" :message="form.errors.end_date" />
        </div>
    </div>
</template>