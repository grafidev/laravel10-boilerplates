<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    form: Object,
    user: { type: Object, required: false },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5 w-2/3">
        <div>
            <Label for="firstname" required>Prénom</Label>
            <TextField type="text" name="firstname" id="firstname" v-model="form.firstname" required/>
            <InputError class="mt-2" :message="form.errors.firstname"/>
        </div>

        <div>
            <Label for="lastname" required>Nom de famille</Label>
            <TextField type="text" name="lastname" id="lastname" v-model="form.lastname" required/>
            <InputError class="mt-2" :message="form.errors.lastname"/>
        </div>

        <div>
            <Label for="email" required>Adresse email</Label>
            <TextField type="email" name="email" id="email" v-model="form.email" required/>
            <InputError class="mt-2" :message="form.errors.email" />
        </div>
        
        <div>
            <Label for="phone_number">Numéro de téléphone</Label>
            <PhoneInput v-model="form.phone_number" name="phone_number" id="phone_number"/>
            <InputError class="mt-2" :message="form.errors.phone_number"/>
        </div>

        <div class="col-span-full">
            <Label for="address">Adresse</Label>
            <TextareaField name="address" id="address" v-model="form.address"/>
            <InputError class="mt-2" :message="form.errors.address" />
        </div>

        <div>
            <Toggle v-model="form.active">{{ form.active ? 'Actif' : 'Inactif' }}</Toggle>
        </div>

        <div class="col-span-full flex items-center justify-end gap-2">
            <SecondaryButton @click.prevent="router.visit(route('dashboard.super_admins.index'))">Annuler</SecondaryButton>
            <PrimaryButton type="submit" :disabled="props.form.processing">Enregistrer</PrimaryButton>
        </div>
    </div>
</template>