<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import ProductFields from './ProductFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    station: Object,
    product: Object,
});

const form = useForm({
    product_category_id: props.product.product_category_id,
    name: props.product.name,
    price: props.product.price,
    notes: props.product.notes,
    station_id: props.station.id,
});

function submit() {
    form.put(route('dashboard.products.update', { product: props.product.id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le produit a bien été modifié.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier un produit" @submit="submit" :processing="form.processing">
        <ProductFields :form="form" />
    </ModalForm>
</template>