<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';
import { Link } from '@inertiajs/vue3';
import { BanknotesIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({ 
    cancellation_requests: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des demandes d'annulation">
        <template #header>
            <DashboardBreadcrumb title="Liste des demandes d'annulation">
                <BreadcrumbItem :url="route('dashboard.cancellation_requests.index')">
                    <BanknotesIcon class="w-5 h-5 mr-2.5"/> Demandes d'annulation
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :filters="props.filters" :perpage="props.perpage" :cancellation_requests="props.cancellation_requests" />
    </DashboardLayout>  
</template>