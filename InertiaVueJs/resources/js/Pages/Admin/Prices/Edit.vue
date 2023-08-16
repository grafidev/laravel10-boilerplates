<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false }, 
    price: Object,
    products: Array,
});

const form = useForm({
    product_id: props.price.product_id,
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
    <ModalForm :show="show" @close="close" title="Ajouter un prix" @submit="submit" :processing="form.processing">
        <Fields :form="form" :products="props.products" />
    </ModalForm>
</template>