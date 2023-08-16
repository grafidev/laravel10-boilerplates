<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

defineProps(['show']);

const form = useForm({
    title: '',
    description: '',
    type: '',
    file: '',
    content: '',
    start_date: '',
    end_date: '',
});

function submit() {
    form.post(route('dashboard.advertisements.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success("La publication a bien été créée.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une publication" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>