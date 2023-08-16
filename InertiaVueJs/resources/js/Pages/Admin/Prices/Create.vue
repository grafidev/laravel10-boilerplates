<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false }, 
    products: Array,
});

const form = useForm({
    product_id: '',
    ttc: '',
    htva: '',
    htt: '',
    starts_at: '',
    ends_at: '',
});

function submit() {
    form.post(route('dashboard.prices.store'), {
        onSuccess: () => {
            close();
            form.reset();
            Alert.success('Le prix a bien été enregistré.');
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Ajouter un prix" @submit="submit" :processing="form.processing">
        <Fields :form="form" :products="props.products" />
    </ModalForm>
</template>