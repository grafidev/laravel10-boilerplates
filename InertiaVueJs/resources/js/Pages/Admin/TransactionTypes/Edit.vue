<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps(['transactionType', 'show']);

const form = useForm({
    name: props.transactionType.name,
    active: props.transactionType.active,
});

function submit() {
    form.put(route('dashboard.transaction-types.update', {transaction_type: props.transactionType.id}), {
        onSuccess: () => {
            close();
            Alert.success('Le type de transaction a bien été modifié.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier le type de transaction" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>