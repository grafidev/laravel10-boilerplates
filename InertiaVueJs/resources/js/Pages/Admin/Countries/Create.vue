<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    countriesList: Array,
    show: { type: Boolean, default: false },
});

const form = useForm({
    code: '',
    dialing_code: '',
});

function submit() {
    form.post(route('dashboard.countries.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le pays a bien été créé.');
        }
    });
}
const close = () => emit('close');

</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un pays" @submit="submit" :processing="form.processing">
        <Fields id="create" :countries-list="props.countriesList" :form="form" />
    </ModalForm>
</template>

