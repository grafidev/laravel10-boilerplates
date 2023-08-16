<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import ProductPriceFields from './ProductPriceFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false }, 
    product: Object,
    settings: Object,
});

const form = useForm({
    ttc: '',
    htva: '',
    htt: '',
    starts_at: '',
    ends_at: '',
});

function submit() {
    form.post(route('dashboard.productPrices.store', { product: props.product.id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le prix a bien été enregistré.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un prix" @submit="submit" :processing="form.processing">
        <ProductPriceFields :settings="props.settings" :product="props.product" :form="form" />
    </ModalForm>
</template>