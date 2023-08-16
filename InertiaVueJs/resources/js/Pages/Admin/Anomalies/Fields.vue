<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <Label for="name" required>Libellé</Label>
            <TextField type="text" name="label" id="label" v-model="form.label" required/>
            <InputError class="mt-2" :message="form.errors.label"/>
        </div>
        
        <div>
            <Label for="date_of_finding" required>Date</Label>
            <DatePicker v-model="form.date_of_finding" required />
            <InputError class="mt-2" :message="form.errors.date_of_finding" />
        </div>
    </div>
</template>