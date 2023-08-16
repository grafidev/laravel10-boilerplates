<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="value" required>Valeur</Label>
            <TextField type="number" name="value" id="value" v-model="form.value" required/>
            <InputError class="mt-2" :message="form.errors.value"/>
        </div>
        
        <div class="col-span-full">
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>