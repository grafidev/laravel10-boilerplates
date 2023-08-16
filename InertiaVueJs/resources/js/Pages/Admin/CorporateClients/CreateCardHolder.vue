<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import CardHolderFields from './CardHolderFields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    corporate_client_id: [String, Number],
});

const form = useForm({
    vehicle_registration_number: '',
    firstname: '',
    lastname: '',
    phone_number: '',
    email: '',
});

function submit() {
    form.post(route('dashboard.card_holders.store', { corporate_client_id: props.corporate_client_id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le porteur de carte a bien été ajouté.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un porteur de carte" @submit="submit" :processing="form.processing">
        <CardHolderFields :form="form" />
    </ModalForm>
</template>