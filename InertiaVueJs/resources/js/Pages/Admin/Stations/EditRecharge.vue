<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import RechargesFields from './RechargesFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    recharge: Object,
    station: Object,
});

const form = useForm({
    amount: props.recharge.amount,
    user_id: props.station.manager.id,
});

const submit = () => {
    form.put(route('dashboard.recharges.update', { recharge: props.recharge.id }), {
        onSuccess: () => {
            close();
            Alert.success('Le montant a bien été modifié.');
        }
    });
};

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier le montant" :processing="form.processing">
        <RechargesFields :form="form" />
    </ModalForm>
</template>