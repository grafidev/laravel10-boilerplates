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
    <div class="grid grid-cols-1 gap-5">
        <div>
            <Label for="numCarte" required>Numéro de carte</Label>
            <TextField type="text" name="numCarte" id="numCarte" v-model="form.numCarte" required/>
            <InputError class="mt-2" :message="form.errors.numCarte"/>
        </div>

        <div>
            <Toggle v-model="form.isBlocked">Bloquer</Toggle>
        </div>
    </div>
</template>