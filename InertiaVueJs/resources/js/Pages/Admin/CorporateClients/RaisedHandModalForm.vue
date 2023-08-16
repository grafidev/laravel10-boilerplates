<script setup>
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
const emit = defineEmits(['close']);
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    }
});

const form = useForm({
    card_number: '',
    card_holder_name: '',
});


const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Main levée" @submit="submit" :processing="form.processing">
    </ModalForm>
</template>