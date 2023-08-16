<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { usePage, router } from '@inertiajs/vue3';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const props = defineProps({ 
    corporateClients: Object, 
    perpage: [String, Number],
    filters: Array,
    products: Array,
});
</script>

<template>
    <DashboardLayout title="Liste des clients pro">
        <template #header>
            <DashboardBreadcrumb title="Liste des clients (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton v-if="auth.permissions.includes('create_corporate_client')" @click.prevent="router.visit(route('dashboard.corporate_clients.create'))">Créer</PrimaryButton>
        </template>

        <Table 
            :perpage="props.perpage" 
            :filters="props.filters" 
            :corporateClients="props.corporateClients" 
            :products="props.products"
        />
    </DashboardLayout>    
</template>