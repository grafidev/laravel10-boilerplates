<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';
import { Alert } from '@/alert';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: '',
    active: false,
});

function submit() {
    form.post(route('dashboard.transaction-types.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le type de transaction a bien été créé.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un type de transaction" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>