<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Select from '@/Components/Select.vue';
import { router } from '@inertiajs/vue3';
const props = defineProps({
    form: Object,
    stations: Array,
});
const cancel = () => {
    router.visit(route('dashboard.terminals.index'));
};
</script>

<template>
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
            <Label for="phone_number" required>Numéro de téléphone</Label>
            <PhoneInput name="phone_number" id="phone_number" v-model="form.phone_number" required />
            <InputError :message="form.errors.phone_number" />
        </div>

        <div>
            <Label for="station_id" required>Station</Label>
            <Select name="station_id" id="station_id" v-model="form.station_id" placeholder="Sélectionner une station" required>
                <option :value="station.id" :key="station.id" v-for="station in props.stations">{{ station.name }}</option>
            </Select>
            <InputError :message="form.errors.station_id" />
        </div>

        <div class="col-span-full">
            <Label for="address">Adresse physique</Label>
            <TextareaField v-model="form.address" />
        </div>

        <div>
            <Label for="email" required>Adresse email</Label>
            <TextField type="email" name="email" id="email" v-model="form.email" required />
            <InputError :message="form.errors.email" />
        </div>

        <div>
            <Label for="lastname" required>Nom de famille</Label>
            <TextField name="lastname" id="lastname" v-model="form.lastname" required />
            <InputError :message="form.errors.lastname" />
        </div>

        <div class="flex items-center justify-end gap-2 col-span-full">
            <SecondaryButton type="button" @click="cancel">Annuler</SecondaryButton>
            <PrimaryButton type="submit">Enregistrer</PrimaryButton>
        </div>
    </div>
</template>