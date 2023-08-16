<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    company: Object,
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: props.company.name,
    active: props.company.active,
    logo: null,
});

const submit = () => form.post(route('dashboard.companies.update', {company: props.company.id}), {
    onSuccess: () => {
        close();
        Alert.success('La compagnie a bien été modifiée.');
    }
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier la compagnie" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>