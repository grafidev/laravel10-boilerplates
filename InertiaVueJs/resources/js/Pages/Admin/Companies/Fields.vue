<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';
import FileUpload from '@/Components/Forms/FileUpload.vue';
const props = defineProps({
    form: Object,
});
</script>
<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" autofocus required />
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div class="col-span-full">
            <FileUpload :name="`logo-${Math.random()}`" @change="file => form.logo = file">Logo</FileUpload>
            <InputError class="mt-2" :message="form.errors.logo" />
        </div>

        <div>
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>