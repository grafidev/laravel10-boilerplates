<script setup>
import DatePicker from '@/Components/Forms/DatePicker.vue';
import Label from '@/Components/Forms/Label.vue';
import RangeSlider from '@/Components/Forms/RangeSlider.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Select from '@/Components/Select.vue';
import SimpleFieldset from '@/Components/SimpleFieldset.vue';
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    filterForm: Object,
    filters: { type: Object, required: false },
    products: Array,
    stations: Array,
    avg: Object,
});

const page = usePage();

const amount_start = ref(props.filters.amount_start);
const amount_end = ref(props.filters.amount_end);

const periods = [
    {label: 'Ce jour', value: 'daily'},
    {label: 'Hier', value: 'yesterday'},
    {label: 'Cette semaine', value: 'weekly'},
    {label: 'Ce mois', value: 'monthly'},
    {label: 'Plage de dates', value: 'range'},
];

const searchByAmount = () => router.get(page.url, { ...props.filters, amount_start: amount_start.value, amount_end: amount_end.value }, {
    preserveState: true,
    replace: true,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-2">
        <div class="col-span-full">
            <Label for="period">Filtrer par période</Label>
            <Select id="period" name="period" v-model="props.filterForm.period" placeholder="Sélectionner la période">
                <option :value="period.value" :key="period.value" v-for="period in periods">{{ period.label }}</option>
            </Select>
        </div>

        <div class="col-span-full grid grid-cols-2 gap-2" v-if="props.filterForm.period === 'range'">
            <div>
                <Label for="starts_at">Date de début</Label>
                <DatePicker name="starts_at" v-model="props.filterForm.starts_at" />
            </div>

            <div>
                <Label for="ends_at">Date de fin</Label>
                <DatePicker name="ends_at" v-model="props.filterForm.ends_at" />
            </div>
        </div>

        <div class="col-span-full">
            <Label for="transaction_type">Filtrer par type</Label>
            <Select id="transaction_type" name="transaction_type" v-model="props.filterForm.transaction_type" placeholder="Sélectionner le type de transaction">
                <option value="achat">ACHAT</option>
                <option value="recharge">RECHARGE</option>
                <option value="annulation">ANNULATION</option>
            </Select>
        </div>

        <div class="col-span-full">
            <Label for="product_slug">Filtrer par produit</Label>
            <Select id="product_slug" name="product_slug" v-model="props.filterForm.product_slug" placeholder="Sélectionner le produit">
                <option :value="product.slug" :key="product.slug" v-for="product in props.products">{{ product.name }}</option>
            </Select>
        </div>

        <div class="col-span-full">
            <Label for="station_name">Filtrer par station</Label>
            <Select id="station_name" name="station_name" v-model="props.filterForm.station_name" placeholder="Sélectionner la station">
                <option :value="station.slug" :key="station.slug" v-for="station in props.stations">{{ station.name }}</option>
            </Select>
        </div>

        <div class="col-span-full">
            <Label for="statut">Filtrer par statut</Label>
            <Select id="statut" name="statut" v-model="props.filterForm.statut" placeholder="Sélectionner le statut">
                <option value="success">SUCCES</option>
                <option value="failed">ECHOUE</option>
            </Select>
        </div>

        <SimpleFieldset title="Filtrer par montant" class="col-span-full">
            <div>
                <Label>Montant min</Label>
                <TextField type="number" disabled :value="amount_start" />
            </div>

            <div>
                <Label>Montant max</Label>
                <TextField type="number" disabled :value="amount_end" />
            </div>

            <div class="col-span-full mt-4">
                <RangeSlider :min="props.avg.amount.min" :max="props.avg.amount.max" id="amount" @submit="searchByAmount" @change:left="value => amount_start = value" @change:right="value => amount_end = value"/>
            </div>
        </SimpleFieldset>
    </div>
</template>