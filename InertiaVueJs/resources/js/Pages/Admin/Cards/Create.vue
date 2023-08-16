<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
});

const form = useForm({
    numCarte: '',
    isBlocked: false,
});

function submit() {
    form.post(route('dashboard.cards.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('La carte a bien été créée.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter une carte" @submit="submit" :processing="form.processing">
        <Fields :form="form"/>
    </ModalForm>
</template>