<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    station: Object,
    show: { type: Boolean, default: false },
    regions: Array,
});

const form = useForm({
    name: props.station.name,
    phone_number: props.station.phone_number,
    region: props.station.region,
    address: props.station.address,
});

function submit() {
    form.put(route('dashboard.stations.update', { station: props.station.id }), {
        onSuccess: () => {
            close();
            Alert.success('La station a bien été modifiée.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier la station" :processing="form.processing">
        <Fields :form="form" id="edit" :regions="props.regions" />
    </ModalForm>
</template>