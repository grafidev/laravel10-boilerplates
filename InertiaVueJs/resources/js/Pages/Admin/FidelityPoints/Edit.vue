<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    fidelity_point: Object,
});

const form = useForm({
    points_required: props.fidelity_point.points_required,
    fidelity_value: props.fidelity_point.fidelity_value,
    active: props.fidelity_point.active,
});

function submit() {
    form.put(route('dashboard.fidelity_points.update', { fidelity_point: props.fidelity_point.id }), {
        onSuccess: () => {
            close();
            Alert.success("Le point de fidélité a bien été modifié.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier un point de fidélité" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>