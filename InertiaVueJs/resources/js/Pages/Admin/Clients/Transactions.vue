<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from '@/Pages/Admin/Transactions/Table.vue';
import { UsersIcon } from '@heroicons/vue/24/outline';
import ClientTabs from './ClientTabs.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    client: Object,
    filters: Object,
    products: Array,
    stations: Array,
    perpage: [String, Number],
    transactions: Object,
    avg: Object,
});
</script>

<template>
    <DashboardLayout :title="`Informations du client ${client.data.name}`">
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
                <Table 
                    :avg="props.avg" 
                    :filters="props.filters" 
                    :products="props.products" 
                    :stations="props.stations" 
                    :perpage="perpage" 
                    :transactions="props.transactions" 
                />
            </ClientTabs>
        </div>
    </DashboardLayout>
</template>