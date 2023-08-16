<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';
import { Alert } from '@/alert';

const emit = defineEmits(['close']);

const props = defineProps(['show']);

const form = useForm({
    value: '',
    active: true,
});

function submit() {
    form.post(route('dashboard.dotationValues.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Enregistrement effectuée avec succès.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une valeur" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>