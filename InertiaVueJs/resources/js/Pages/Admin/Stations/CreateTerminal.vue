<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import TerminalFields from './TerminalFields.vue';

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
    station_id: props.station.id,
    address: '',

    brand: '',
    model: '',
    serial_number: '',
});

function submit() {
    form.post(route('dashboard.terminals.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le terminal a bien été créé.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" :title="`Ajouter un terminal pour la station ${props.station.name}`" @submit="submit" :processing="form.processing">
        <TerminalFields :form="form" />
    </ModalForm>
</template>