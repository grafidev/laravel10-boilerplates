<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import FormCard from '@/Components/FormCard.vue';
import { BanknotesIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import TransactionCancellationForm from './TransactionCancellationForm.vue';
import TransactionDetails from './TransactionDetails.vue';
import TransactionDetailsModal from './TransactionDetailsModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    transaction: Object,
    original_transaction: Object,
});

const showCancellation = ref(false);
const showTransaction = ref(false);
</script>

<template>
    <DashboardLayout title="Informations sur la transaction">
        <template #header>
            <DashboardBreadcrumb title="Informations sur la transaction">
                <BreadcrumbItem :url="route('dashboard.transactions.index')">
                    <BanknotesIcon class="w-5 h-5 mr-2.5"/> Transactions
                </BreadcrumbItem>
                <BreadcrumbItem>{{ transaction.data.transaction_reference }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <DangerButton v-if="! transaction.data.cancelled && transaction.data.status !== 'failed'" @click.prevent="showCancellation = true">Annuler la transaction</DangerButton>
            <PrimaryButton v-if="props?.original_transaction !== null" @click.prevent="showTransaction = true">Voir la transaction annulée</PrimaryButton>
            <TransactionDetailsModal :show="showTransaction" @close="showTransaction = false" :transaction="props.original_transaction?.data" />
        </template>

        <TransactionCancellationForm :show="showCancellation" @close="showCancellation = false" :transaction="props.transaction.data"/>

        <FormCard :title="`Transaction n° ${props.transaction.data.transaction_reference}`">
            <TransactionDetails :transaction="props.transaction.data" />
        </FormCard>
    </DashboardLayout>
</template>