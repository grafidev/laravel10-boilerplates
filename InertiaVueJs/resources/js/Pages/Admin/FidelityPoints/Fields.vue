<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <Label for="points_required" required>Points requis</Label>
            <TextField type="number" name="points_required" id="points_required" v-model="form.points_required" required/>
            <InputError class="mt-2" :message="form.errors.points_required"/>
        </div>
        
        <div>
            <Label for="fidelity_value" required>Valeur</Label>
            <TextField type="number" name="fidelity_value" id="fidelity_value" v-model="form.fidelity_value" required/>
            <InputError class="mt-2" :message="form.errors.fidelity_value" />
        </div>
        <div class="col-span-full">
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>