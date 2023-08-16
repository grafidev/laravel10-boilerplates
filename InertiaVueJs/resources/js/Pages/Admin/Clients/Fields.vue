<script setup>
import Label from '@/Components/Forms/Label.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import PinCodeField from '@/Components/Forms/PinCodeField.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import PinCodeGeneratorButton from '@/Components/PinCodeGeneratorButton.vue';
import { Cog6ToothIcon } from '@heroicons/vue/24/outline';
const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <Label for="firstname" required>Prénom</Label>
            <TextField name="firstname" id="firstname" v-model="form.firstname" required/>
            <InputError :message="form.errors.firstname" />
        </div>
        
        <div>
            <Label for="lastname" required>Nom de famille</Label>
            <TextField name="lastname" id="lastname" v-model="form.lastname" required />
            <InputError :message="form.errors.lastname" />
        </div>

        <div class="col-span-full">
            <Label for="phone_number" required>Numéro de téléphone</Label>
            <PhoneInput name="phone_number" id="phone_number" v-model="form.phone_number" required/>
            <InputError :message="form.errors.phone_number" />
        </div>

        <div class="col-span-full">
            <div class="flex items-center gap-2 mb-2">
                <Label required class="mb-0">Mot de passe </Label>
                <PinCodeGeneratorButton @on-generate="value => props.form.password = value" :length="5" />
            </div>
            <PinCodeField v-model="props.form.password" required />
            <InputError :message="form.errors.password" />
        </div>
    </div>
</template>