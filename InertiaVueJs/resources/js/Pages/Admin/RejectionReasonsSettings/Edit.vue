<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    rejectionReason: Object,
});

const form = useForm({
    name: props.rejectionReason.name,
    description: props.rejectionReason.description,
    active: props.rejectionReason.active,
});

const submit = () => form.put(route('dashboard.rejectionReasons.update', { rejectionReason: props.rejectionReason.id }), {
    onSuccess: () => {
        close();
        Alert.success("Le motif de rejet a bien été modifié.");
    }
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier le motif de rejet" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>