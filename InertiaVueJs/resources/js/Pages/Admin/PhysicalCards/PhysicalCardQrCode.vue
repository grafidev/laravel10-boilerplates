<script setup>
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import QrCode from '@/Components/QrCode.vue';
const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    physical_card: Object,
});
const close = () => emit('close');
</script>

<template>
    <Modal :show="props.show" @close="close">
        <ModalContent title="Code QR de la carte" @close="close">
            <div class="flex flex-col items-center">
                <span class="text-2xl font-extrabold">{{ props.physical_card.serial_number }}</span>
                <QrCode :scale="6" download print :text="props.physical_card.crypted_token" :id="props.physical_card.id" />
            </div>
        </ModalContent>
    </Modal>
</template>