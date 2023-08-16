<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import Toggle from '@/Components/Forms/Toggle.vue';
import Select from '@/Components/Select.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';
import FileUpload from '@/Components/Forms/FileUpload.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Loader from '@/Components/Loader.vue';
import { router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { getCurrencies, isoToEmoji } from '@/utils';
import MultipleCheckInput from '@/Components/Forms/MultipleCheckInput.vue';
import { useSearch } from '@/composables';
import { getParamByISO } from 'iso-country-currency';
import api from '@/api';
import RadioField from '@/Components/Forms/RadioField.vue';

const props = defineProps({
    form: Object,
    roles: Array,
    countries: Array,
    companies: Array,
    products: Array,
    user: { type: Object, required: false },
});

const [searchProductTerm, loadedProducts, productIds] = useSearch({
    items: props.products, 
    field: 'name',
    valueKey: 'id',
});

const loading = ref(false);
const allSelectedProducts = computed(() => props.form.products.length === loadedProducts.value?.length);

const selectAllProducts = () => props.form.products = productIds;
const unSelectAllProducts = () => props.form.products = [];

const findCountryDetails = (country_id) => {
    api().get(route('api.countries.show', { id: country_id })).then(({ data }) => {
        props.form.country_id = data.id;
        props.form.currency = getParamByISO(data.code, 'currency');
    }).catch(error => {
        console.log(error);
        props.form.currency = 'XOF';
    }).finally(_ => {
        loading.value = false;
    });
};

watch(() => props.form.country_id, country_id => {
    if(! country_id) return;
    loading.value = true;
    findCountryDetails(country_id);
}, { immediate: true });

const countryChanged = ({ iso2 }) => findCountryDetails(iso2);
</script>

<template>
    <div class="grid grid-cols-2 gap-5 w-2/3">
        <Loader :loading="loading" />

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
            <PhoneInput v-model="form.phone_number" name="phone_number" id="phone_number" required :single-country="false" @country-changed="countryChanged" />
            <InputError class="mt-2" :message="form.errors.phone_number"/>
        </div>

        <div v-if="!props.user?.id">
            <Label for="country_id" required>Pays</Label>
            <Select name="country_id" id="country_id" v-model="form.country_id" placeholder="Sélectionner un pays">
                <option :value="country.id" v-for="country in props.countries" :key="country.id">
                    {{ isoToEmoji(country.code) }} {{ country.name }}
                </option>
            </Select>
            <InputError class="mt-2" :message="form.errors.country_id"/>
        </div>

        <div>
            <Label for="currency">Devise</Label>
            <Select name="currency" id="currency" v-model="form.currency" placeholder="Sélectionner une devise">
                <option :value="currency.value" :key="currency.value" v-for="currency in getCurrencies()">{{ currency.label }}</option>
            </Select>
            <InputError :message="form.errors.currency" />
        </div>

        <div class="col-span-full" v-if="!props.user?.id">
            <Label for="roles">Compagnie(s)</Label>
            <div class="grid grid-cols-3 gap-2 py-0">
                <RadioField name="company_id" :id="`company-${company.id}`" :value="company.id" :chosen-value="company.id" @change="value => form.company_id = value" :key="company.id" v-for="company in props.companies">
                    {{ company.name }}
                </RadioField>
            </div>
            <InputError :message="form.errors.company_id"  class="mt-3"/>
        </div>

        <div class="col-span-full">
            <Label for="roles">Produit(s)</Label>
            <div class="bg-white col-span-2 py-2  sticky top-0 z-20 dark:bg-gray-800">
                <SearchField v-model="searchProductTerm" placeholder="Rechercher" class="w-full"/>
                <div class="col-span-2 mt-2">
                    <a href="#" v-if="allSelectedProducts" class="link underline" @click.prevent="unSelectAllProducts">Tout désélectionner</a>
                    <a href="#" v-else class="link underline" @click.prevent="selectAllProducts">Tout sélectionner</a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 py-0">
                <MultipleCheckInput
                    v-for="product in loadedProducts"
                    :key="product.id"
                    :value="product.id"
                    :id="`product-${product.id}`"
                    v-model="form.products"
                >
                    {{ product.name }}
                </MultipleCheckInput>
            </div>

            <InputError :message="form.errors.products" class="mt-3" />
        </div>

        <div class="col-span-full">
            <Label for="app_logo">Logo</Label>
            <FileUpload :label="false" name="app_logo" v-model="form.app_logo" />
            <InputError :message="form.errors.app_logo" />
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
            <SecondaryButton @click.prevent="router.visit(route('dashboard.customers.index'))">Annuler</SecondaryButton>
            <PrimaryButton type="submit" :disabled="props.form.processing">Enregistrer</PrimaryButton>
        </div>
    </div>
</template>