<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';

const props = defineProps({
    form: Object,
});
</script>
<template>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <Label for="firstname" required>Prénom</Label>
            <TextField type="text" name="firstname" v-model="form.firstname" required/>
            <InputError class="mt-2" :message="form.errors.firstname"/>
        </div>

        <div>
            <Label for="lastname" required>Nom de famille</Label>
            <TextField type="text" name="lastname" v-model="form.lastname" required/>
            <InputError class="mt-2" :message="form.errors.lastname"/>
        </div>

        <div>
            <Label required>Adresse email</Label>
            <TextField type="email" name="email" v-model="form.email" required/>
            <InputError class="mt-2" :message="form.errors.email" />
        </div>
        
        <div>
            <Label required>Numéro de téléphone</Label>
            <PhoneInput v-model="form.phone_number" name="phone_number" required/>
            <InputError class="mt-2" :message="form.errors.phone_number"/>
        </div>
    </div>
</template>