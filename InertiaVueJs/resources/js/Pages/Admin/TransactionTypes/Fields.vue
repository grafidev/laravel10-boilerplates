<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import Toggle from '@/Components/Forms/Toggle.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
});
</script>
<template>
    <div class="grid grid-cols-1 gap-5">
        <div>
            <Label for="name" required>Libellé</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" required/>
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div>
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>