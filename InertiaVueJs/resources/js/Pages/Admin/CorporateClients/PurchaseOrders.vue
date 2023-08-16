<script setup>
import { ref } from 'vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CreatePurchaseOrder from './CreatePurchaseOrder.vue';
import { usePage } from '@inertiajs/vue3';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import CorporateClientTabs from './CorporateClientTabs.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import PurchaseOrderQrCode from '../PurchaseOrders/PurchaseOrderQrCode.vue';

const { auth } = usePage().props;

const props = defineProps({
    corporateClient: Object,
    cardHolders: Object,
    purchaseOrders: Object,
    products: Array,
    stations: Array,
});

const createPurchaseOrder = ref(false);
const editingPurchaseOrder = ref(null);
</script>

<template>
    <DashboardLayout title="Informations du client (entreprise)">
        <template #header>
            <DashboardBreadcrumb title="Informations du client (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.corporateClient.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Bons de carburant</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CreatePurchaseOrder :products="props.products" :corporate_client_id="props.corporateClient.data.id" :show="createPurchaseOrder" @close="createPurchaseOrder = false"/>

        <div class="space-y-2">
            <CorporateClientTabs :corporate-client="props.corporateClient.data">
                <FormCard title="Bons de carburant">
                    <template #actions>
                        <PrimaryButton @click.prevent="createPurchaseOrder = true">Ajouter un bon de carburant</PrimaryButton>
                    </template>

                    <Table>
                        <Thead v-if="props.purchaseOrders.data.length">
                            <Tr>
                                <Th class="text-center"><SortableLink label="Montant" attribute="amount" /></Th>
                                <Th class="text-center"><SortableLink label="Etat" attribute="active" /></Th>
                                <Th class="text-center"><SortableLink label="Date d'utilisation" attribute="date_of_use" /></Th>
                                <Th class="text-center"><SortableLink label="Date de création" attribute="created_at" /></Th>
                                <Th class="text-center">Actions</Th>
                            </Tr>
                        </Thead>
                        <Tbody>
                            <NoRecords v-if="props.purchaseOrders.data.length == 0" title="Aucun bon de carburant enregistré" colspan="4"/>
                            <Tr v-for="purchaseOrder in props.purchaseOrders.data" :key="purchaseOrder.id">
                                <Td>
                                    <NumberFormatter :value="purchaseOrder.amount" currency="XOF" />
                                </Td>
                                <Td>
                                    <ActiveIcon :active="purchaseOrder.active" />
                                </Td>
                                <Td><DateForHumans :date="purchaseOrder.date_of_use"/></Td>
                                <Td><DateForHumans :date="purchaseOrder.created_at"/></Td>
                                <Td class="text-center">
                                    <PrimaryButton @click.prevent="editingPurchaseOrder = purchaseOrder.id">Voir code QR</PrimaryButton>
                                    <PurchaseOrderQrCode :purchase_order="purchaseOrder" :show="editingPurchaseOrder == purchaseOrder.id" @close="editingPurchaseOrder = null"/>    
                                </Td>
                            </Tr>
                        </Tbody>
                    </Table>
                </FormCard>
            </CorporateClientTabs>
        </div>
    </DashboardLayout>
</template>