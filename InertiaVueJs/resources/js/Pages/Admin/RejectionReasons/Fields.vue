<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import InputError from '@/Components/InputError.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import Toggle from '@/Components/Forms/Toggle.vue';

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" required/>
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>
        
        <div class="col-span-full">
            <Label for="description">Description</Label>
            <TextareaField name="description" id="description" v-model="form.description"/>
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="col-span-full">
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>