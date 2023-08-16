<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import PurchaseOrderFields from './PurchaseOrderFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    corporate_client_id: [String, Number],
    products: Array,
});

const form = useForm({
    count: 1,
    product_id: '',
    amount: '',
    corporate_client_id: props.corporate_client_id,
    station_id: '',
});

const submit = () => form.post(route('dashboard.purchase_orders.store', { corporate_client_id: props.corporate_client_id }), {
    onSuccess: () => {
        close();
        form.reset();
        Alert.success('Le bon de carburant a bien été ajouté.');
    }
});
const close = () => emit('close');
</script>

<template>
    <ModalForm submit-text="Générer" :show="show" @close="close" title="Ajouter un bon de carburant" @submit="submit" :processing="form.processing">
        <PurchaseOrderFields :form="form" :products="props.products"/>
    </ModalForm>
</template>