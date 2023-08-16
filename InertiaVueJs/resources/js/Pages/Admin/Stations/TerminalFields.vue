<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import InputError from '@/Components/InputError.vue';
import Fieldset from '@/Components/Fieldset.vue';
const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="space-y-4">
        <Fieldset title="À propos du pompiste" :toggleable="false">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <Label for="firstname" required>Prénom</Label>
                    <TextField name="firstname" id="firstname" v-model="form.firstname" required />
                    <InputError :message="form.errors.firstname" />
                </div>
        
                <div>
                    <Label for="lastname" required>Nom de famille</Label>
                    <TextField name="lastname" id="lastname" v-model="form.lastname" required />
                    <InputError :message="form.errors.lastname" />
                </div>
                <div>
                    <Label for="email" required>Adresse email</Label>
                    <TextField type="email" name="email" id="email" v-model="form.email" required />
                    <InputError :message="form.errors.email" />
                </div>
                <div>
                    <Label for="phone_number" required>Numéro de téléphone</Label>
                    <PhoneInput name="phone_number" id="phone_number" v-model="form.phone_number" required />
                    <InputError :message="form.errors.phone_number" />
                </div>
                <div class="col-span-full">
                    <Label for="address">Adresse physique</Label>
                    <TextareaField v-model="form.address" />
                </div>
            </div>
        </Fieldset>
        <Fieldset title="À propos du terminal" :toggleable="false">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <Label for="brand" required>Marque</Label>
                    <TextField name="brand" id="brand" v-model="form.brand" required />
                    <InputError :message="form.errors.brand" />
                </div>
                <div>
                    <Label for="model" required>Modèle</Label>
                    <TextField name="model" id="model" v-model="form.model" required />
                    <InputError :message="form.errors.model" />
                </div>
                <div>
                    <Label for="serial_number" required>Numéro de série</Label>
                    <TextField name="serial_number" id="serial_number" v-model="form.serial_number" required />
                    <InputError :message="form.errors.serial_number" />
                </div>
            </div>
        </Fieldset>
    </div>
</template>