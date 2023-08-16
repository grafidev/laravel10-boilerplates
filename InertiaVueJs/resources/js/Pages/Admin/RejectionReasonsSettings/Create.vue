<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps(['show']);

const form = useForm({
    name: '',
    description: '',
    active: true,
});

const submit = () => form.post(route('dashboard.rejectionReasons.store'), {
    onSuccess: () => {
        close();
        form.reset();
        Alert.success("Le motif de rejet a bien été créé.");
    }
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un motif de rejet" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>