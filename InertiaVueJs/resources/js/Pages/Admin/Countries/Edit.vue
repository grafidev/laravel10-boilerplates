<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    countriesList: Array,
    show: { type: Boolean, default: false },
    country: Object,
});

const form = useForm({
    code: props.country.code,
});

const submit = () => {
    form.put(route('dashboard.countries.update', { country: props.country.id }), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le pays a bien été modifié.');
        }
    });
};
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier un pays" @submit="submit" :processing="form.processing">
        <Fields id="edit" :countries-list="props.countriesList" :form="form" />
    </ModalForm>
</template>

