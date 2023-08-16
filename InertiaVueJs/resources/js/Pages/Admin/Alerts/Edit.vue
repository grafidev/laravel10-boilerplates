<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    alert: Object,
});

const form = useForm({
    title: props.alert.title,
    description: props.alert.description,
    type: props.alert.type,
    file: props.alert.file,
    content: props.alert.content,
    start_date: props.alert.start_date,
    end_date: props.alert.end_date,
});

function submit() {
    form.put(route('dashboard.alerts.update', { alert: props.alert.id }), {
        onSuccess: () => {
            close();
            Alert.success("La publication a bien été modifiée.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier une alerte" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>