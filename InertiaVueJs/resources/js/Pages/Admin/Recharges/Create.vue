<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    users: Array,
});

const form = useForm({
    amount: '',
    user_id: '',
});

function submit() {
    form.post(route('dashboard.recharges.store'), {
        onSuccess: () => {
            close();
            Alert.success('La recharge a bien été enregistrée.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Effectuer une recharge" :processing="form.processing">
        <Fields :form="form" :recharge="props.recharge" :users="props.users" />
    </ModalForm>
</template>