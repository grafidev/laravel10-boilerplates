<script setup>
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import QrCode from '@/Components/QrCode.vue';

const emit = defineEmits(['close']);
const props = defineProps({ purchase_order: Object, show: { type: Boolean, default: false } });
const close = () => emit('close');
</script>

<template>
    <Modal :show="props.show" @close="close">
        <ModalContent title="Code QR du bon de carburant" @close="close">
            <div class="flex flex-col items-center gap-2">
                <span class="text-xl font-extrabold">{{ props.purchase_order.serial_number }}</span>
                <QrCode download print :scale="6" :id="`purchase-order-${props.purchase_order.id}`" :text="props.purchase_order.crypted_number" />
            </div>
        </ModalContent>
    </Modal>
</template>