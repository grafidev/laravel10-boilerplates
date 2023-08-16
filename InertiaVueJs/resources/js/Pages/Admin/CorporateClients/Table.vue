<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { onMounted, ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import ButtonDropdown from '@/Components/ButtonDropdown.vue';
import { initDropdowns } from 'flowbite';
import ButtonDropdownItem from '@/Components/ButtonDropdownItem.vue';
import CreateCardHolder from './CreateCardHolder.vue';
import CreatePurchaseOrder from './CreatePurchaseOrder.vue';
import { useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props = defineProps({ 
    corporateClients: Object, 
    perpage: [String, Number],
    filters: Array,
    products: Array,
});

const { auth } = usePage().props;

const search             = ref(props.filters.search);
const overflowTable      = ref(true);
const creatingCardHolder = ref(null);
const creatingPurchaseOrder = ref(null);

const onChangePerPage = perpage => changePerPage(page, route('dashboard.corporate_clients.index'));

watch(search, (value) => {
    router.get(route('dashboard.corporate_clients.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});



const { selected, checkAll, onSelectRow } = useCheckAll(props.corporateClients.data);

const bulkActions = [
    { label: 'Exporter', id: 'export' },
];

const handleBulkActions = action => {
    if(action.id === 'export') {
        alert('Export à implémenter...');
    }
};

onMounted(() => {
    initDropdowns();
});
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="handleBulkActions" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un client (entreprise)" />
        </template>
    </SearchWrapper>

    <Table :overflow="overflowTable">
        <Thead v-if="props.corporateClients.data.length">
            <Tr>
                <Th class="w-4 p-4"><CheckInput v-model="checkAll" /></Th>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Adresse" attribute="address" /></Th>
                <Th><SortableLink label="Numéro de téléphone" attribute="phone_number" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.corporateClients.data.length == 0" title="Aucun client (entreprise) enregistré" />
            
            <Tr v-for="client in props.corporateClients.data" :key="client.id">
                <Td class="w-4 p-4">
                    <CheckInput :value="client.id" :checked="selected.includes(client.id)" @change="onSelectRow(client.id, $event.target.checked)" />
                </Td>
                <Td>{{ client.name }}</Td>
                <Td>{{ client.address }}</Td>
                <Td>{{ client.phone_number }}</Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton v-if="auth.permissions.includes('show_corporate_client')" variant="blue" @click.prevent="router.visit(route('dashboard.corporate_clients.show', { corporate_client: client.id }))">Voir</SecondaryButton>
                        <ButtonDropdown title="Actions" @opened="overflowTable = false" @closed="overflowTable = true">
                            <ButtonDropdownItem @click.prevent="router.visit(route('dashboard.corporate_clients.edit', { corporate_client: client.id }))">Modifier</ButtonDropdownItem>
                            <ButtonDropdownItem @click.prevent="creatingCardHolder = client.id">Créer porteur de carte</ButtonDropdownItem>
                            <ButtonDropdownItem @click.prevent="creatingPurchaseOrder = client.id">Créer bon de carburant</ButtonDropdownItem>
                        </ButtonDropdown>
                    </ButtonGroup>

                    <CreateCardHolder :corporate_client_id="client.id" :show="creatingCardHolder == client.id" @close="creatingCardHolder = null"/>
                    <CreatePurchaseOrder :corporate_client_id="client.id" :show="creatingPurchaseOrder == client.id" @close="creatingPurchaseOrder = false" :products="props.products"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.corporateClients.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.corporateClients.meta.links" />
</template>