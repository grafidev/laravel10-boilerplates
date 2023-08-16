<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps(['card', 'show']);

const form = useForm({
    numCarte: props.card.numCarte,
    isBlocked: props.card.isBlocked,
});

function submit() {
    form.put(route('dashboard.cards.update', {card: props.card.id}), {
        onSuccess: () => {
            close();
            Alert.success('La carte a bien été modifiée.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier la carte" :processing="form.processing">
        <Fields :form="form"/>
    </ModalForm>
</template>