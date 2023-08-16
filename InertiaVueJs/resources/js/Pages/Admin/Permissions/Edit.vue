<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    permission: Object,
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: props.permission.name,
    description: props.permission.description,
})

function submit() {
    form.put(route('dashboard.permissions.update', {permission: props.permission.id}), {
        onSuccess: () => {
            close();
            Alert.success('La permission a bien été modifiée.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier la permision" :processing="form.processing">
        <Fields :form="form" :permission="props.permission" />
    </ModalForm>
</template>