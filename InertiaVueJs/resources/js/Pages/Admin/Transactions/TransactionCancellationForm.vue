<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import Label from '@/Components/Forms/Label.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import api from '@/api';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    transaction: Object,
});

const form = useForm({
    cancellation_reason: '',
});

const submit = () => {
    Alert.confirm('Sûr. Sûr.e ?', result => {
        if(result.isConfirmed) {
            form.put(route('dashboard.transactions.cancel', { transaction: props.transaction.id }), {
                onSuccess: () => {
                    close();
                    form.reset();
                }
            });
        }
    });
};
const close = () => emit('close');
</script>

<template>
    <ModalForm submit-text="Soumettre" :show="show" @close="close" :title="`Annulation de la transaction ${props.transaction.transaction_reference}`" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-full">
                <Label for="cancellation_reason" required>Raison de l'annulation</Label>
                <TextareaField v-model="form.cancellation_reason" name="cancellation_reason" id="cancellation_reason" required/>
                <InputError class="mt-2" :message="form.errors.cancellation_reason" />
            </div>
        </div>
    </ModalForm>
</template>