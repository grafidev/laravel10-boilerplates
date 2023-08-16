<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Tabs from '@/Components/Tabs.vue';
import { Link, usePage } from '@inertiajs/vue3';
import UserDetails from './UserDetails.vue';
import WalletDetails from './WalletDetails.vue';
import Table from '@/Pages/Admin/Transactions/Table.vue';
import { UsersIcon } from '@heroicons/vue/24/outline';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { downloadQrCode } from '@/utils';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { printQrcode } from '@/composables';
import ClientTabs from './ClientTabs.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    client: Object,
    filters: Object,
    products: Array,
    stations: Array,
    transactionPerpage: [String, Number],
    transactions: Object,
});
</script>

<template>
    <DashboardLayout :title="`Informations du client ${client.name}`">
        <template #header>
            <DashboardBreadcrumb title="Informations du client">
                <BreadcrumbItem :url="route('dashboard.clients.index')">
                    <UsersIcon class="w-5 h-5 mr-2.5" /> Clients
                </BreadcrumbItem>
                <BreadcrumbItem>{{ client.data.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <div class="space-y-2">
            <ClientTabs :client="client.data">
                <div class="grid grid-cols-2 gap-1"> 
                    <div class="space-y-3">
                        <WalletDetails :client="client.data" :wallet="client.data.wallet"/>
    
                        <div class="flex items-center justify-center gap-2">
                            <PrimaryButton @click.prevent="downloadQrCode(`qrcode-client${client.data.wallet.id}`)">Télécharger</PrimaryButton>
                            <SecondaryButton @click.prevent="printQrcode({ id: `qrcode-client${client.data.wallet.id}` })">Imprimer</SecondaryButton>
                        </div>
                    </div>

                    <div class="mx-auto px-3 w-full pt-5">
                        <UserDetails :user="client.data" />
                    </div>
                </div>
            </ClientTabs>
        </div>
    </DashboardLayout>
</template>