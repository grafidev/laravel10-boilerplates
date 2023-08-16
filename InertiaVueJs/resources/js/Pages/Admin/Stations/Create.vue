<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    regions: Array,
});

const form = useForm({
    name: '',
    phone_number: '',
    region: '',
    has_manager: false,
    manager_firstname: '',
    manager_lastname: '',
    manager_email: '',
    manager_phone_number: '',
    address: '',
});

const submit = () => form.post(route('dashboard.stations.store'), {
    onSuccess: () => {
        close();
        form.reset();
        Alert.success('La station service a bien été créée.');
    }
});
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une station service" @submit="submit" :processing="form.processing">
        <Fields :form="form" id="create" :regions="props.regions" />
    </ModalForm>
</template>