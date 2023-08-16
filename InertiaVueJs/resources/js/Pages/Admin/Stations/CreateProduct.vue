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
    product_category_id: '',
    name: '',
    price: '',
    notes: '',
    station_id: '',
});

function submit() {
    form.post(route('dashboard.products.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le produit a bien été créé.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un produit" @submit="submit" :processing="form.processing">
        <ProductFields :form="form" />
    </ModalForm>
</template>