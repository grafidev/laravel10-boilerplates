<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import TerminalFields from './TerminalFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    station: Object,
    terminal: Object,
});

const form = useForm({
    firstname: props.terminal.firstname,
    lastname: props.terminal.lastname,
    email: props.terminal.email,
    phone_number: props.terminal.phone_number,
    address: props.terminal.address,
    brand: props.terminal.terminalInfo.brand,
    model: props.terminal.terminalInfo.model,
    serial_number: props.terminal.terminalInfo.serial_number,
    station_id: props.station.id,
});

function submit() {
    form.put(route('dashboard.terminals.update', { terminal: props.terminal.id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le terminal a bien été modifié.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier un terminal" @submit="submit" :processing="form.processing">
        <TerminalFields :form="form" />
    </ModalForm>
</template>