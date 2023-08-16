<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps(['show']);

const form = useForm({
    firstname: '',
    lastname: '',
    phone_number: '',
    password: '',
});

function submit() {
    form.post(route('dashboard.clients.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success("Le client a bien été enregistré.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un client" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>