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
    minimal_amount: '',
    earned_points: '',
});

const submit = () => {
    form.post(route('dashboard.companies.fidelity_points_settings.store'), {
        onSuccess: () => {
            close();
            Alert.success('Enregistrement effectué avec succès.');
        },
    });
};
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une configuration" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>