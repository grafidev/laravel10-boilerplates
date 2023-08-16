<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    product: Object,
    show: { type: Boolean, default: false },
    categories: Array,
    stations: Array,
});

const form = useForm({
    product_type: props.product.product_type,
    name: props.product.name,
    notes: props.product.notes,
    active: props.product.active,
});

function submit() {
    form.put(route('dashboard.products.update', {product: props.product.id}), {
        onSuccess: () => {
            close();
            Alert.success('Le produit a bien été modifié.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier le produit" :processing="form.processing">
        <Fields :form="form" :product="props.product.id"/>
    </ModalForm>
</template>