<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    categories: Array,
    stations: Array,
});

const form = useForm({
    product_type: 'CARBURANT',
    name: '',
    notes: '',
    active: true,
});

const submit = () => {
    form.post(route('dashboard.settings.products.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le produit a bien été créé.');
        }
    });
};
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un produit" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>