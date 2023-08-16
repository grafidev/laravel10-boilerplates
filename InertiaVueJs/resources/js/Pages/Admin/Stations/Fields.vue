<script setup>
import Label from '@/Components/Forms/Label.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';
import Select from '@/Components/Select.vue';
import { usePage } from '@inertiajs/vue3';
import TextareaField from '@/Components/Forms/TextareaField.vue';
const props = defineProps({
    form: Object,
    id: String,
    regions: Array,
});
const { auth } = usePage().props;
</script>
<template>
    <div class="grid grid-cols-2 gap-4" :class="{'mb-4': props.id === 'create'}">
        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" required />
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div>
            <Label for="phone_number" required>Numéro de téléphone</Label>
            <PhoneInput type="text" name="phone_number" id="phone_number" v-model="form.phone_number" required :default-country="auth.country.code"/>
            <InputError class="mt-2" :message="form.errors.phone_number" />
        </div>

        <div>
            <Label for="region" required>Région</Label>
            <Select name="region" id="region" v-model="form.region" required placeholder="Sélectionner une région">
                <option :value="region.name" :key="region.name" v-for="region in props.regions">{{ region.name }}</option>
            </Select>
            <InputError class="mt-2" :message="form.errors.region" />
        </div>

        <div class="col-span-full">
            <Label for="address">Adresse</Label>
            <TextareaField id="address" v-model="form.address" />
            <InputError class="mt-2" :message="form.errors.address" />
        </div>

        <div class="col-span-full" v-if="props.id == 'create'">
            <Toggle v-model="form.has_manager">Affecter un gérant</Toggle>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4" v-if="props.id === 'create' && form.has_manager">
        <div>
            <Label for="manager_firstname" :required="form.has_manager">Prénom du gérant</Label>
            <TextField type="text" name="manager_firstname" id="manager_firstname" v-model="form.manager_firstname" :required="form.has_manager"/>
            <InputError class="mt-2" :message="form.errors.manager_firstname"/>
        </div>

        <div>
            <Label for="manager_lastname" :required="form.has_manager">Nom du gérant</Label>
            <TextField type="text" name="manager_lastname" id="manager_lastname" v-model="form.manager_lastname" :required="form.has_manager"/>
            <InputError class="mt-2" :message="form.errors.manager_lastname"/>
        </div>

        <div>
            <Label for="manager_email" :required="form.has_manager">Email du gérant</Label>
            <TextField type="email" name="manager_email" id="manager_email" v-model="form.manager_email" :required="form.has_manager"/>
            <InputError class="mt-2" :message="form.errors.manager_email"/>
        </div>

        <div>
            <Label for="manager_phone_number" :required="form.has_manager">Numéro de téléphone du gérant</Label>
            <PhoneInput name="manager_phone_number" id="manager_phone_number" v-model="form.manager_phone_number" :required="form.has_manager"/>
            <InputError class="mt-2" :message="form.errors.manager_phone_number" />
        </div>
    </div>
</template>