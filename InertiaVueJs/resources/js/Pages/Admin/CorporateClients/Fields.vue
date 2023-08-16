<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FileUpload from '@/Components/Forms/FileUpload.vue';
import Select from '@/Components/Select.vue';
import { router, usePage } from '@inertiajs/vue3';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import Fieldset from '@/Components/Fieldset.vue';
import { getCurrencies } from '@/utils'
const props = defineProps({
    form: Object,
});
const cancel = () => {
    router.visit(route('dashboard.corporate_clients.index'));
};

const { auth } = usePage().props;

const regimes = [
    {label: 'HTVA', value: 'htva'},
    {label: 'HTT', value: 'htt'},
    {label: 'TTC', value: 'ttc'},
];
</script>

<template>
    <Fieldset title="Informations" :toggleable="false">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <Label for="name" required>Nom</Label>
                <TextField name="name" id="name" v-model="form.name" autofocus required/>
                <InputError :message="form.errors.name" />
            </div>
    
            <div>
                <Label for="ninea" required>NINEA</Label>
                <TextField name="ninea" id="ninea" v-model="form.ninea" required />
                <InputError :message="form.errors.ninea" />
            </div>
            
            <div>
                <Label for="address" required>Adresse</Label>
                <TextField name="address" id="address" v-model="form.address" required/>
                <InputError :message="form.errors.address" />
            </div>
    
            <div>
                <Label for="email" required>Adresse email</Label>
                <TextField type="email" name="email" id="email" v-model="form.email" required/>
                <InputError :message="form.errors.email" />
            </div>
    
            <div>
                <Label for="phone_number" required>Numéro de téléphone</Label>
                <PhoneInput name="phone_number" id="phone_number" v-model="form.phone_number" required  />
                <InputError :message="form.errors.phone_number" />
            </div>
    
            <div>
                <Label for="contact_name">Nom du contact</Label>
                <TextField name="contact_name" id="contact_name" v-model="form.contact_name" />
                <InputError :message="form.errors.contact_name" />
            </div>
    
            <div>
                <Label for="contact_email">Email du contact</Label>
                <TextField name="contact_email" id="contact_email" v-model="form.contact_email" />
                <InputError :message="form.errors.contact_email" />
            </div>
    
            <div>
                <Label for="contact_phone_number">Numéro de téléphone du contact</Label>
                <PhoneInput name="contact_phone_number" id="contact_phone_number" v-model="form.contact_phone_number" :default-country="auth.country.code" />
                <InputError :message="form.errors.contact_phone_number" />
            </div>
    
            <div class="col-span-full grid grid-cols-3 gap-5">
                <div>
                    <Label for="commercial_register_number">Numéro de registre</Label>
                    <TextField name="commercial_register_number" id="commercial_register_number" v-model="form.commercial_register_number" />
                    <InputError :message="form.errors.commercial_register_number" />
                </div>
    
                <div>
                    <Label for="commercial_register_file">Registre de commerce</Label>
                    <FileUpload :label="false" name="commercial_register_file" v-model="form.commercial_register_file" />
                    <InputError :message="form.errors.commercial_register_file" />
                </div>
    
                <div>
                    <Label for="exoneration_title">Titre d'exonération</Label>
                    <FileUpload :label="false" name="exoneration_title" v-model="form.exoneration_title" />
                    <InputError :message="form.errors.exoneration_title" />
                </div>
            </div>
        </div>
    </Fieldset>

    <Fieldset title="Finances" :toggleable="false">
        <div class="grid grid-cols-4 gap-4">
            <div>
                <Label for="regime" required>Régime</Label>
                <Select name="regime" id="regime" placeholder="Sélectionner un régime" v-model="form.regime" required>
                    <option :value="regime.value" :key="regime.value" v-for="regime in regimes">{{ regime.label }}</option>
                </Select>
                <InputError :message="form.errors.regime" />
            </div>

            <div>
                <Label for="discount">Remise</Label>
                <TextField type="number" name="discount" id="discount" v-model="form.discount" />
                <InputError :message="form.errors.discount" />
            </div>

            <div>
                <Label for="currency">Devise</Label>
                <Select name="currency" id="currency" v-model="form.currency" placeholder="Sélectionner une devise">
                    <option :value="currency.value" :key="currency.value" v-for="currency in getCurrencies()">{{ currency.label }}</option>
                </Select>
                <InputError :message="form.errors.currency" />
            </div>

            <div>
                <Label for="periodicity">Périodicité</Label>
                <TextField type="number" name="periodicity" id="periodicity" v-model="form.periodicity" />
                <InputError :message="form.errors.periodicity" />
            </div>
        </div>
    </Fieldset>

    <div class="col-span-full flex items-center justify-end gap-2">
        <SecondaryButton type="button" @click="cancel">Annuler</SecondaryButton>
        <PrimaryButton type="submit">Enregistrer</PrimaryButton>
    </div>
</template>