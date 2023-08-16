<script setup>
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import NoRecords from '@/Components/NoRecords.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    selected: Array,
});

const submit = () => {
    alert('Activation par lot');
};

const close = () => emit('close');
</script>

<template>
    <Modal :show="props.show" @close="close">
        <ModalContent title="Activer les cartes sélectionées" @close="close">
            <ul v-if="props.selected.length" class="space-y-3">  
                <li class="grid grid-cols-3 gap-2 mb-2 shadow-md border p-2">
                    <span class="font-extrabold">Numéro de série</span>
                    <span class="font-extrabold">Client</span>
                    <span class="font-extrabold">Demandeur</span>
                </li>

                <li v-for="item in props.selected" :key="item.id" class="grid grid-cols-3 gap-3 shadow-md border p-2">
                    <span>{{ item.serial_number }}</span>
                    <span>{{ item.user?.name }}</span>
                    <span>{{ item.requesting_user?.name }}</span>
                </li>
            </ul>

            <NoRecords v-else title="Aucune des cartes sélectionnées ne fait l'objet d'une demande" />
            
            <div v-if="props.selected.length" class="flex items-center justify-end gap-2 mt-5">
                <SecondaryButton @click.prevent="close">Annuler</SecondaryButton>
                <PrimaryButton @click.prevent="submit">Activer</PrimaryButton>
            </div>
        </ModalContent>
    </Modal> 
</template>