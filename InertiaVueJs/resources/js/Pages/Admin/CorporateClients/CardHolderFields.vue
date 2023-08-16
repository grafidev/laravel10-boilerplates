<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <Label for="firstname" required>Prénom</Label>
            <TextField name="firstname" id="firstname" v-model="form.firstname" required/>
            <InputError class="mt-2" :message="form.errors.firstname"/>
        </div>

        <div>
            <Label for="lastname" required>Nom de famille</Label>
            <TextField name="lastname" id="lastname" v-model="form.lastname" required/>
            <InputError class="mt-2" :message="form.errors.lastname"/>
        </div>

        <div>
            <Label for="phone_number" required>Numéro de téléphone</Label>
            <PhoneInput name="phone_number" id="phone_number" v-model="form.phone_number" required />
            <InputError class="mt-2" :message="form.errors.phone_number"/>
        </div>

        <div>
            <Label for="email">Adresse email</Label>
            <TextField type="email" name="email" id="email" v-model="form.email" />
            <InputError class="mt-2" :message="form.errors.email"/>
        </div>

        <div class="col-span-full">
            <Label for="vehicle_registration_number">Numéro d'immatriculation de véhicule</Label>
            <TextField name="vehicle_registration_number" id="vehicle_registration_number" v-model="form.vehicle_registration_number" />
            <InputError class="mt-2" :message="form.errors.vehicle_registration_number"/>
        </div>
    </div>
</template>