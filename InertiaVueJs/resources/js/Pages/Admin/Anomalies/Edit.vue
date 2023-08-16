<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    anomaly: Object,
});


const form = useForm({
    label: props.anomaly.label,
    date_of_finding: props.anomaly.date_of_finding
});

function submit() {
    form.put(route('dashboard.anomalies.update', { anomaly: props.anomaly.id }), {
        onSuccess: () => {
            close();
            Alert.success("L'anomalie a bien été modifiée.");
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier une anomalie" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>