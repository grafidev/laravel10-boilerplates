<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    recharge: Object,
    show: { type: Boolean, default: false },
    users: Array,
});

const form = useForm({
    amount: props.recharge.amount,
    user_id: props.recharge.user_id,
});

function submit() {
    form.put(route('dashboard.recharges.update', {recharge: props.recharge.id}), {
        onSuccess: () => {
            close();
            Alert.success('La recharge a bien été modifiée.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier une recharge" :processing="form.processing">
        <Fields :form="form" :recharge="props.recharge" :users="props.users" />
    </ModalForm>
</template>