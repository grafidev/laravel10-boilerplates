<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: '',
});

function submit() {
    form.post(route('dashboard.product-categories.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('La catégorie de produit a bien été créée.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une catégorie de produit" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>