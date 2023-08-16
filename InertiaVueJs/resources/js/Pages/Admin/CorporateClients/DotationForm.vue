<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Label from '@/Components/Forms/Label.vue';
import Select from '@/Components/Select.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import { watch } from 'vue';
import RadioField from '@/Components/Forms/RadioField.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    corporateClient: Object,
    products: Array,
    cardHolder: Object,
});

const form = useForm({
    dotation_type: 'value',
    dotation_value: '',
    product_id: '',
    quantity: 1,
    current_price: '',
    value: '',
});

const dotationTypes = [
    {label: 'Par valeur', value: 'value'},
    {label: 'Par litre', value: 'liter'},
];


watch(() => form.dotation_type, type => {
    if(type == 'value') {
        form.product_id = '';
        form.quantity = 1;
        form.current_price = '';
        form.value = '';
    } else if(type == 'liter') {
        form.dotation_value = '';
    }
})

watch(() => form.product_id, product_id => {
    if(product_id === '') return;

    axios.get(route('dashboard.products.price_details', { product: product_id })).then(({ data }) => {
        const current_price = data.data.ttc;
        form.current_price = current_price;
        form.value = form.quantity * form.current_price;
    }).catch(error => {
        Alert.error(error.response.data.message);
    });
});

watch(() => form.quantity, quantity => {
    form.value = quantity * form.current_price;
});

const submit = () => {
    form.post(route('dashboard.endowments.store', { card_holder: props.cardHolder.id }), {
        onSuccess: () => {
            Alert.success('Dotation appliquée avec succès.');
            close();
        },
    })
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Dotation" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-full">
                <Label for="dotation_type" required>Type de dotation</Label>
                <div class="grid grid-cols-1 gap-4">
                    <RadioField :chosen-value="form.dotation_type" @change="value => form.dotation_type = value" name="dotationType" :id="dotationType.value" :value="dotationType.value" v-for="(dotationType, index) in dotationTypes" :key="index">{{ dotationType.label }}</RadioField>
                </div>
            </div>

            <div class="col-span-full" v-if="form.dotation_type == 'value'">
                <Label for="dotation_value">Valeur</Label>
                <TextField type="number" name="dotation_value" id="dotation_value" v-model="form.dotation_value" placeholder="Montant" step="1000"/>
                <InputError class="mt-2" :message="form.errors.dotation_value" />
            </div>

            <div class="col-span-full grid grid-cols-2 gap-3" v-if="form.dotation_type == 'liter'">
                <div>
                    <Label for="product_id" required>Carburant</Label>
                    <Select name="product_id" id="product_id" v-model="form.product_id" placeholder="Choisir le type de carburant" required>
                        <option :value="product.id" :key="product.id" v-for="product in props.products">{{ product.name }}</option>
                    </Select>
                    <InputError class="mt-2" :message="form.errors.product_id"/>
                </div>

                <div>
                    <Label for="quantity" required>Quantité</Label>
                    <TextField type="number" name="quantity" id="quantity" v-model="form.quantity" required min="1" />
                    <InputError class="mt-2" :message="form.errors.quantity" />
                </div>

                <div>
                    <Label for="current_price" required>Prix actuel</Label>
                    <TextField type="number" name="current_price" id="current_price" v-model="form.current_price" required disabled />
                    <InputError class="mt-2" :message="form.errors.current_price" />
                </div>

                <div>
                    <Label for="value" required>Valeur</Label>
                    <TextField type="number" name="value" id="value" v-model="form.value" required disabled />
                    <InputError class="mt-2" :message="form.errors.value" />
                </div>
            </div>
        </div>
    </ModalForm>
</template>