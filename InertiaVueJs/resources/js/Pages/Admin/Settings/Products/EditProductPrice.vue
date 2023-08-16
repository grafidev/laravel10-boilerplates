<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import ProductPriceFields from './ProductPriceFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false }, 
    product: Object,
    price: Object,
});

const form = useForm({
    product_id: props.product.id,
    ttc: props.price.ttc,
    htva: props.price.htva,
    htt: props.price.htt,
    starts_at: props.price.starts_at,
    ends_at: props.price.ends_at,
});

function submit() {
    form.put(route('dashboard.prices.update', { price: props.price.id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le prix a bien été modifié.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier un prix" @submit="submit" :processing="form.processing">
        <ProductPriceFields :product="props.product" :form="form" />
    </ModalForm>
</template>