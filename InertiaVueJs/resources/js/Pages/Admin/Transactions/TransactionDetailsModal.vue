<script setup>
import Modal from '@/Components/Modal.vue';
import TransactionDetails from './TransactionDetails.vue';
import ModalContent from '@/Components/ModalContent.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    transaction: Object,
});

const close = () => emit('close');
</script>

<template>
    <Modal :show="props.show" @close="close">
        <ModalContent :title="`À propos de la transaction N° ${props.transaction.transaction_reference}`" @close="close">
            <TransactionDetails :transaction="props.transaction" />
        </ModalContent>
    </Modal>
</template>