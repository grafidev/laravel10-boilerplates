<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

defineProps(['show']);

const form = useForm({
    points_required: '',
    fidelity_value: '',
    active: true,
});

function submit() {
    form.post(route('dashboard.fidelity_points.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success("Le point de fidélité a bien été créé.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un point de fidélité" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>