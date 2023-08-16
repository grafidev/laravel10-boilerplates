<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    cancellation_reason: Object,
});

const form = useForm({
    name: props.cancellation_reason.name
});

const submit = () => {
    form.put(route('dashboard.companies.cancellation_reasons.update', { cancellation_reason: props.cancellation_reason.id }), {
        onSuccess: () => {
            close();
            Alert.success("Modification effectuée avec succès.");
        },
    });
};

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="props.show" @close="close" :processing="form.processing" title="Modifier la raison" @submit="submit">
        <Fields :form="form" />
    </ModalForm>    
</template>