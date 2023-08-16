<script setup>
import Badge from '@/Components/Badge.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import Label from '@/Components/Forms/Label.vue';
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import TransactionTypeBadge from '@/Components/TransactionTypeBadge.vue';
import UserDetailsModal from '@/Components/Users/UserDetailsModal.vue';
import { ref } from 'vue';
import UserDetails from '../Clients/UserDetails.vue';

const props = defineProps({ transaction: Object });
const showTerminalDetails = ref(false);
const showSenderDetails = ref(false);
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <Label for="station_name">Station</Label>   
            <p>{{ transaction.station?.name }}</p>
        </div>

        <div v-if="transaction.receiver">
            <Label for="receiver">{{ transaction.receiver?.roles.map(role => role.description).join(', ') }}</Label>   
            <p>
                <a href="#" @click.prevent="showTerminalDetails = true" class="text-green-500 underline">{{ transaction.receiver?.name }}</a>
            </p>

            <Modal :show="showTerminalDetails" @close="showTerminalDetails = null">
                <ModalContent :title="`À propos de ${transaction.receiver.name}`" @close="showTerminalDetails = null">
                    <UserDetails :user="transaction.receiver" />
                </ModalContent>
            </Modal>
        </div>

        <div v-if="transaction.corporate_client">
            <Label>Entreprise</Label>
            <p>{{ transaction.corporate_client.name }}</p>
        </div>

        <div>
            <Label for="sender">{{ transaction.sender?.roles.map(role => role.description).join(', ') }}</Label>   
            <p>
                <a href="#" @click.prevent="showSenderDetails = true" class="text-green-500 underline">
                    {{ transaction.sender?.name }}
                </a>
            </p>

            <Modal :show="showSenderDetails" @close="showSenderDetails = null">
                <ModalContent :title="`À propos de ${transaction.sender.name}`" @close="showSenderDetails = null">
                    <UserDetails :user="transaction.sender" />
                </ModalContent>
            </Modal>
        </div>

        <div>
            <Label for="name">Montant</Label>   
            <p><NumberFormatter :value="transaction.amount" currency="XOF"/></p>
        </div>

        <div>
            <Label for="name">Date</Label>   
            <p><DateForHumans :date="transaction.created_at"/></p>
        </div>

        <div>
            <Label for="transaction_type">Type de transaction</Label>   
            <p>
                <TransactionTypeBadge :name="transaction.transaction_type?.name">{{ transaction.transaction_type?.name }}</TransactionTypeBadge>
            </p>
        </div>

        <div>
            <Label for="liters_count">Nombre de litres</Label>   
            <p>{{ transaction.liters_count }}</p>
        </div>

        <div v-if="transaction.product?.name">
            <Label for="product_name">Produit</Label>   
            <p>{{ transaction.product?.name }}</p>
        </div>

        <div>
            <Label for="status_label">Statut</Label>   
            <p>
                <Badge color="success" v-if="transaction.status === 'success'">{{ transaction.status_label }}</Badge> 
                <Badge color="danger" v-if="transaction.status === 'failed'">{{ transaction.status_label }}</Badge>
            </p>
        </div>

        <div v-if="transaction.failure_reason">
            <Label for="failure_reason">Raison d'échec</Label>   
            <p>{{ transaction.failure_reason }}</p>
        </div>
    </div>
</template>