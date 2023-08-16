<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';

import { usePage } from '@inertiajs/vue3';
import { UserIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const props = defineProps({ 
    cardHolders: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des porteurs de carte">
        <template #header>
            <DashboardBreadcrumb title="Liste des porteurs de carte">
                <BreadcrumbItem :url="route('dashboard.card_holders.index')">
                    <UserIcon class="w-5 h-5 mr-2.5"/> Porteurs de carte
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :filters="props.filters" :perpage="perpage" :card-holders="props.cardHolders" />
    </DashboardLayout>    
</template>