<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Table from './Table.vue';
import { CreditCardIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const props = defineProps({
    perpage: [String, Number],
    filters: Object,
    physical_cards: Object,
    station_managers: Array,
});
</script>

<template>
    <DashboardLayout title="Demandes de rattachement">
        <template #header>
            <DashboardBreadcrumb title="Demandes de rattachement">
                <BreadcrumbItem :url="route('dashboard.physical_cards.index')">
                    <CreditCardIcon class="w-5 h-5 mr-2.5"/> Demandes de rattachement
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <Table :perpage="props.perpage" :filters="props.filters" :physical_cards="props.physical_cards"/>
    </DashboardLayout>
</template>