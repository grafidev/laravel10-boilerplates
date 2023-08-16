<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import AssignStationManagerFields from './AssignStationManagerFields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    station: Object,
});

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    phone_number: '',
});

const submit = () => form.post(route('dashboard.station_managers.store', { station: props.station.id }), {
    onSuccess: () => {
        close();
        form.reset();
        Alert.success('Gérant enregistré avec succès');
    }
});
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Affecter un gérant" @submit="submit" :processing="form.processing">
        <AssignStationManagerFields :form="form" />
    </ModalForm>
</template>