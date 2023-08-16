<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';

import { usePage } from '@inertiajs/vue3';
import { DocumentTextIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const props = defineProps({ 
    purchaseOrders: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des Bons de carburant">
        <template #header>
            <DashboardBreadcrumb title="Liste des Bons de carburant">
                <BreadcrumbItem :url="route('dashboard.purchase_orders.index')">
                    <DocumentTextIcon class="w-5 h-6 mr-2.5"/> Bons de carburant
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :filters="props.filters" :perpage="props.perpage" :purchase-orders="props.purchaseOrders" />
    </DashboardLayout>    
</template>