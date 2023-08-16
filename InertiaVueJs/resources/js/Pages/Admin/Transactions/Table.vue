<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed, watch } from 'vue';
import { router, usePage, useForm, Link } from '@inertiajs/vue3';
import { changePerPage, exportData } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import FilterDropdown from '@/Components/FilterDropdown.vue';
import NoRecords from '@/Components/NoRecords.vue';
import Badge from '@/Components/Badge.vue';
import TransactionFiltersFields from './TransactionFiltersFields.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { getFiltersCount, useCheckAll } from '@/composables';
import DateForHumans from '@/Components/DateForHumans.vue';
import UserCell from '../Users/UserCell.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import BulkActions from '@/Components/BulkActions.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import TransactionTypeBadge from '@/Components/TransactionTypeBadge.vue';
import CorporateClientInfo from './CorporateClientInfo.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props    = defineProps({ 
    transactions: Object, 
    products: Array, 
    stations: Array, 
    filters: Object,
    perpage: [String, Number],
    avg: Object,
});

const page     = usePage();
const { auth } = page.props;

const onChangePerPage = (p) => {
    changePerPage(p, page.url);
};

const filterForm = useForm({
    search: props.filters.search,
    transaction_type: props.filters.transaction_type,
    product_slug: props.filters.product_slug,
    station_id: props.filters.station_id,
    period: props.filters.period,
    station_name: props.filters.station_name,
    statut: props.filters.statut,
    starts_at: props.filters.starts_at,
    ends_at: props.filters.ends_at,
    amount_start: props.filters.amount_start,
    amount_end: props.filters.amount_end,
});

const filtersCount = computed(() => getFiltersCount(filterForm))
const filtering = computed(() => filtersCount.value > 0);

const resetFilters = () => {
    router.visit(page.url);
};

for(const key in filterForm.data()) {
    watch(() => filterForm[key], value => {
        router.get(page.url, { ...props.filters, [key]: value }, {
            preserveState: true,
            replace: true,
        });
    });
}

watch(() => filterForm.search, (value) => {
    router.get(page.url, { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const { selected, checkAll, onSelectRow } = useCheckAll(props.transactions.data);

const bulkActions = [
    { label: 'Exporter', id: 'export' }, 
];

const onHandleBulkAction = action => {
    if(action.id === 'export') {
        alert('TODO: export transactions');
    }
};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="onHandleBulkAction" />
        </template>
        <template #end>
            <SearchField v-model="filterForm.search" placeholder="Rechercher une transaction" />
            <FilterDropdown :filtersCount="filtersCount" :filtering="filtering" @reset-filters="resetFilters" class="ml-2 border-none">
                <TransactionFiltersFields :avg="props.avg" :filters="props.filters" :stations="props.stations" :products="props.products" :filter-form="filterForm" />
            </FilterDropdown>
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.transactions.data.length">
            <Tr>
                <Th>
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Station" attribute="station.name" /></Th>
                <Th><SortableLink label="Terminal" attribute="receiver_name" /></Th>
                <Th><SortableLink label="Client" attribute="sender_name" /></Th>
                <Th><SortableLink label="Entreprise" attribute="corporate_client.name" /></Th>
                <Th><SortableLink label="Montant" attribute="amount" /></Th>
                <Th><SortableLink label="Produit" attribute="product.name" /></Th>
                <Th><SortableLink label="Date et heure" attribute="created_at" /></Th>
                <Th><SortableLink label="Type de transaction" attribute="transaction_type.name" /></Th>
                <Th><SortableLink label="Statut" attribute="status" /></Th>
                <Th><SortableLink label="ID de transaction" attribute="transaction_reference" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.transactions.data.length == 0" title="Aucune transaction enregistrée" />

            <Tr v-for="transaction in props.transactions.data" :key="transaction.id" :url="route('dashboard.transactions.show', {id: transaction.id})">
                <Td class="w-4 p-4" @click.stop>
                    <CheckInput :value="transaction.id" :checked="selected.includes(transaction.id)" @change="onSelectRow(transaction.id, $event.target.checked)" />
                </Td>
                <Td @click.stop>
                    <Link v-if="transaction.station" class="text-green-500 font-bold hover:underline" :href="route('dashboard.stations.show', { station: transaction.station.id })">
                        {{ transaction.station?.name }}
                    </Link>
                    <span v-else>---</span>
                </Td>
                <Td><UserCell :user="transaction.receiver" /></Td>
                <Td><UserCell :user="transaction.sender" /></Td>
                <Td @click.stop><CorporateClientInfo :data="transaction.corporate_client" /></Td>
                <Td><NumberFormatter :value="transaction.amount" currency="XOF" /></Td>
                <Td>{{ transaction.product?.name || '---' }}</Td>
                <Td><DateForHumans :date="transaction.created_at"/></Td>
                <Td><TransactionTypeBadge :name="transaction.transaction_type?.name">{{ transaction.transaction_type?.name }}</TransactionTypeBadge></Td>
                <Td>
                    <Badge color="success" v-if="transaction.status == 'success'">{{ transaction.status_label }}</Badge> 
                    <Badge color="danger" v-else>{{ transaction.status_label }}</Badge> 
                </Td>
                <Td>{{ transaction.transaction_reference }}</Td>
                <Td>
                    <SecondaryButton @click.prevent="router.visit(route('dashboard.transactions.show', {id: transaction.id}))">Voir</SecondaryButton>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="transactions.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="transactions.meta.links" />
</template>