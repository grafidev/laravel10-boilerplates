<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    point: { type: Object },
});

const form = useForm({
    minimal_amount: props.point.minimal_amount,
    earned_points: props.point.earned_points,
});

function submit() {
    form.put(route('dashboard.companies.fidelity_points_settings.update', {fidelity_point_settings: props.point.id }), {
        onSuccess: () => {
            Alert.success('Configuration modifiée avec succès');
            close();
        },
    })
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier une configuration" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template> 