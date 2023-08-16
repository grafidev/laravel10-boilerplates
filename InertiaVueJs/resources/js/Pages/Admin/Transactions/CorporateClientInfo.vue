<script setup>
import Modal from "@/Components/Modal.vue";
import ModalContent from "@/Components/ModalContent.vue";
import { ref } from "vue";
import CorporateClientDetails from "../CorporateClients/CorporateClientDetails.vue";

const props = defineProps({
    data: Object,
});
const showDetails = ref(false);
</script>

<template>
    <div v-if="props.data">
        <a href="#" @click.prevent="showDetails = true" class="text-green-500 underline">{{ props.data.name }}</a>
        <Modal :show="showDetails" @close="showDetails = false">
            <ModalContent :title="`À propos de l'entreprise ${props.data.name}`" @close="showDetails = false">
                <CorporateClientDetails :corporate-client="props.data" />
            </ModalContent>
        </Modal>
    </div>
    <span v-else>---</span>
</template>