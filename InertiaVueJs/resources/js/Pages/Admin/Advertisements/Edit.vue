<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    advertisement: Object,
});

const form = useForm({
    title: props.advertisement.title,
    description: props.advertisement.description,
    type: props.advertisement.type,
    file: props.advertisement.file,
    content: props.advertisement.content,
    start_date: props.advertisement.start_date,
    end_date: props.advertisement.end_date,
});

function submit() {
    form.put(route('dashboard.advertisements.update', { advertisement: props.advertisement.id }), {
        onSuccess: () => {
            close();
            Alert.success("La publication a bien été modifiée.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier une publication" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>