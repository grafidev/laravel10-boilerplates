<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from '@/Pages/Admin/DotationValues/Fields.vue';
import { Alert } from '@/alert';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    dotationValue: Object,
});

const form = useForm({
    value: props.dotationValue.value,
    active: props.dotationValue.active,
});

function submit() {
    form.put(route('dashboard.dotationValues.update', { dotationValue: props.dotationValue.id }), {
        onSuccess: () => {
            close();
            Alert.success('Modification effectuée avec succès.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Modifier la valeur" @submit="submit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>