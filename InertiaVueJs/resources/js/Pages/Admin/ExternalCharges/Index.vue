<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Table from './Table.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline';

const props = defineProps({ 
    recharges: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Recharges externes">
        <template #header>
            <DashboardBreadcrumb title="Recharges externes">
                <BreadcrumbItem :url="route('dashboard.external_charges.index')">
                    <ArrowTopRightOnSquareIcon class="w-5 h-5 mr-2.5"/> Recharges externes
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :filters="props.filters" :perpage="props.perpage" :recharges="props.recharges" />
    </DashboardLayout>    
</template>