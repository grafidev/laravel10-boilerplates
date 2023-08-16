<script setup>
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: ''
});

const submit = () => {
    form.post(route('dashboard.companies.cancellation_reasons.store'), {
        onSuccess: () => {
            close();
            Alert.success("Enregistrement effectué avec succès.");
        },
    });
};

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="props.show" @close="close" :processing="form.processing" title="Nouvelle raison" @submit="submit">
        <Fields :form="form" />
    </ModalForm>    
</template>