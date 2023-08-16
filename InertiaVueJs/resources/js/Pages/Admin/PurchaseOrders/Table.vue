<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import NoRecords from '@/Components/NoRecords.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import ValidatePurchaseOrderForm from './ValidatePurchaseOrderForm.vue';
import { useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import BulkValidationForm from './BulkValidationForm.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import { notices } from '@/composables';
import PurchaseOrderQrCode from './PurchaseOrderQrCode.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import DateForHumans from '@/Components/DateForHumans.vue';


const props    = defineProps({ 
    purchaseOrders: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const { auth } = usePage().props;
const showValidatePurchaseOrder = ref(null);
const showBulkValidationForm = ref(false);
const showQrCode = ref(null);

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.purchase_orders.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.purchase_orders.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const { selected, checkAll, onSelectRow } = useCheckAll(props.purchaseOrders.data);

const form = useForm({
    notice: notices.default,
    comment: '',
    purchaseOrderIds: selected,
});

const submit = () => form.post(route('dashboard.purchase-orders.bulkValidation'), {
    onSuccess() {
        showBulkValidationForm.value = false;
        form.reset();
    }
});

const bulkActions = [
    { label: 'Valider les bons', id: 'validate' }, 
];

const onHandleBulkAction = action => {
    if(action.id === 'validate') {
        showBulkValidationForm.value = true;
    }
}
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="onHandleBulkAction" />
            <BulkValidationForm :selected-purchase-orders="selected" :show="showBulkValidationForm" @close="showBulkValidationForm = false" @submit="submit" :form="form" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un bon de carburant" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.purchaseOrders.data.length">
            <Tr>
                <Th>
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Entreprise" attribute="corporate_client.name" /></Th>
                <Th><SortableLink label="Montant" attribute="amount" /></Th>
                <Th><SortableLink label="Etat" attribute="active" /></Th>
                <Th><SortableLink label="Numéro de série" attribute="serial_number" /></Th>
                <Th><SortableLink label="Statut actuel" attribute="purchase_order_status.name" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th>Actions</Th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.purchaseOrders.data.length == 0" title="Aucun bon de carburant enregistré" />
            
            <Tr v-for="purchase_order in props.purchaseOrders.data" :key="purchase_order.id">
                <Td class="w-4 p-4">
                    <CheckInput
                        :value="purchase_order.id"
                        :checked="selected.includes(purchase_order.id)" 
                        @change="onSelectRow(purchase_order.id, $event.target.checked)" 
                    />
                </Td>
                <Td>
                    {{ purchase_order.corporate_client?.name }}
                </Td>
                <Td><NumberFormatter :value="purchase_order.amount" currency="XOF" /></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <ActiveIcon :active="purchase_order.active" />
                    </div>
                </Td>
                <Td>{{ purchase_order.serial_number }}</Td>
                <Td>
                    <StatusBadge :name="purchase_order.purchase_order_status.name">
                        {{ purchase_order.purchase_order_status.description }}
                    </StatusBadge>
                </Td>
                <Td><DateForHumans :date="purchase_order.created_at"/></Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton @click.prevent="showQrCode = purchase_order.id">Voir Code QR</SecondaryButton>
                        <SecondaryButton @click.prevent="router.visit(route('dashboard.purchase_orders.show', { purchase_order: purchase_order.id }))">Voir</SecondaryButton>
                        <PrimaryButton @click.prevent="router.visit(route('dashboard.purchase_orders.show', { purchase_order: purchase_order.id }))">Valider</PrimaryButton>
                    </ButtonGroup>

                    <PurchaseOrderQrCode :purchase_order="purchase_order" :show="showQrCode == purchase_order.id" @close="showQrCode = null"/>    
                    <ValidatePurchaseOrderForm :purchase_order="purchase_order" :show="showValidatePurchaseOrder == purchase_order.id" @close="showValidatePurchaseOrder = null"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.purchaseOrders.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.purchaseOrders.meta.links" />
</template>