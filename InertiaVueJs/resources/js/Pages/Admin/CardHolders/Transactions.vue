<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { usePage, router } from '@inertiajs/vue3';
import Table from '@/Pages/Admin/Transactions/Table.vue';
import { UsersIcon } from '@heroicons/vue/24/outline';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import CardHolderTabs from './CardHolderTabs.vue';

const props = defineProps({
    cardHolder: Object,
    filters: Object,
    products: Array,
    stations: Array,
    perpage: [String, Number],
    transactions: Object,
    avg: Object,
});
</script>

<template>
    <DashboardLayout :title="`Informations du porteur de carte ${cardHolder.data.name}`">
        <template #header>
            <DashboardBreadcrumb title="Informations du porteur de carte">
                <BreadcrumbItem :url="route('dashboard.card_holders.index')">
                    <UsersIcon class="w-5 h-5 mr-2.5" /> Porteurs de carte
                </BreadcrumbItem>
                <BreadcrumbItem>{{ cardHolder.data.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton 
                v-if="cardHolder.data.has_endowments_to_validate"
                @click.prevent="router.visit(route('dashboard.card_holders.validationForm', { card_holder: cardHolder.data.id }))">
                Valider la dotation
            </PrimaryButton>
        </template>

        <CardHolderTabs :card_holder="cardHolder.data">
            <Table :avg="props.avg" :filters="props.filters" :products="props.products" :stations="props.stations" :perpage="props.perpage" :transactions="props.transactions" />
        </CardHolderTabs>
    </DashboardLayout>
</template>