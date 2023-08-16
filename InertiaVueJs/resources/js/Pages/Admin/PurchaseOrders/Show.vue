<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreacrumb from '@/Components/DashboardBreadcrumb.vue';
import CorporateClientDetails from '@/Pages/Admin/CorporateClients/CorporateClientDetails.vue';
import PurchaseOrderDetails from './PurchaseOrderDetails.vue';
import { Link } from '@inertiajs/vue3'
import ValidationForm from './ValidationForm.vue';
import { DocumentTextIcon } from '@heroicons/vue/24/outline';
import Card from '@/Components/Card.vue';
import FormCard from '@/Components/FormCard.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    purchaseOrder: Object,
});
</script>

<template>
    <DashboardLayout title="Détails sur le bon de carburant">
        <template #header>
            <DashboardBreacrumb title="Infos sur le bon de carburant">
                <BreadcrumbItem :url="route('dashboard.purchase_orders.index')">
                    <DocumentTextIcon class="w-5 h-5 mr-2.5" /> Bons de carburant
                </BreadcrumbItem>
                <BreadcrumbItem>Détails sur le bon de carburant {{ props.purchaseOrder.data.serial_number }}</BreadcrumbItem>
            </DashboardBreacrumb>
        </template>

        <div class="space-y-3">
            <div class="grid grid-cols-3 gap-2 items-start">
                <div class="col-span-2 space-y-3">
                    <FormCard :title="`Détails sur le bon de carburant ${props.purchaseOrder.data.serial_number}`">
                        <PurchaseOrderDetails :purchase-order="props.purchaseOrder.data"/>
                    </FormCard>
                </div>
                <div>
                    <ValidationForm :purchase-order="props.purchaseOrder.data" />
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>