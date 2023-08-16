<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

defineProps(['show']);

const form = useForm({
    label: '',
    date_of_finding: ''
});

function submit() {
    form.post(route('dashboard.anomalies.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success("L'anomalie a bien été créée.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une anomalie" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>