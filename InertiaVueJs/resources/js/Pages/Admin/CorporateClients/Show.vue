<script setup>
import CorporateClientDetails from './CorporateClientDetails.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import CorporateClientTabs from './CorporateClientTabs.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;
const props = defineProps({
    corporateClient: Object,
});
</script>

<template>
    <DashboardLayout title="Informations du client (entreprise)">
        <template #header>
            <DashboardBreadcrumb title="Informations du client (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.corporateClient.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Détails</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>


        <div class="space-y-2">
            <CorporateClientTabs :corporate-client="props.corporateClient.data">
                <FormCard :title="`Détails sur l'entreprise ${props.corporateClient.data.name}`">
                    <CorporateClientDetails :corporate-client="props.corporateClient.data" />
                </FormCard>
            </CorporateClientTabs>
        </div>
    </DashboardLayout>
</template>