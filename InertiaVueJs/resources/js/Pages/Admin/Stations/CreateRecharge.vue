<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import RechargesFields from './RechargesFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    station: Object,
    terminals: Array,
});

const form = useForm({
    amount: '',
    user_id: props.station.manager?.id,
    user_type: 'GERANT_STATION',
    terminal_id: '',
    station_id: props.station.id,
});

function submit() {
    form.post(route('dashboard.recharges.store'), {
        onSuccess: () => {
            close();
            Alert.success('La recharge a bien été enregistrée.');
            form.reset();
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" :title="`Nouvelle recharge du gérant ${props.station.manager?.name}`" :processing="form.processing">
        <RechargesFields :form="form" :terminals="props.terminals" />
    </ModalForm>
</template>