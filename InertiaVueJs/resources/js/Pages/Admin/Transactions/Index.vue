<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';
import { BanknotesIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({ 
    transactions: Object, 
    products: Array,
    stations: Array,
    perpage: [String, Number],
    filters: Object,
    avg: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des transactions">
        <template #header>
            <DashboardBreadcrumb title="Liste des transactions">
                <BreadcrumbItem :url="route('dashboard.transactions.index')">
                    <BanknotesIcon class="w-5 h-5 mr-2.5"/> Transactions
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :avg="props.avg" :filters="props.filters" :products="props.products" :stations="props.stations" :perpage="perpage" :transactions="props.transactions" />
    </DashboardLayout>
</template>