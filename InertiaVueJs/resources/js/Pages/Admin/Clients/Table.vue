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
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const props    = defineProps({ clients: Object, perpage: [String, Number], filters: Object, })
const search   = ref(props.filters.search);
const { auth } = usePage().props;
const { selected, checkAll, onSelectRow } = useCheckAll(props.clients.data);

const onChangePerPage = (page) => changePerPage(page, route('dashboard.clients.index'));

watch(search, (value) => {
    router.get(route('dashboard.clients.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const bulkActions = [
    { label: 'Exporter', id: 'export'},
];

const handleBulkActions = action => {
    if(action.id === 'export') {
        alert('Export à implémenter');
    }
};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="handleBulkActions" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un client" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.clients.data.length">
            <Tr>
                <Th>
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Prénom" attribute="firstname" /></Th>
                <Th><SortableLink label="Nom de famille" attribute="lastname" /></Th>
                <Th><SortableLink label="Numéro de téléphone" attribute="phonenumber" /></Th>
                <Th><SortableLink label="Solde" attribute="wallet.balance" /></Th>
                <Th><SortableLink label="Etat du compte" attribute="active" /></Th>
                <Th><SortableLink label="Etat du portefeuille" attribute="active" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.clients.data.length == 0" title="Aucun client enregistré" />
            
            <Tr v-for="client in props.clients.data" :key="client.id" :url="route('dashboard.clients.show', {id: client.id})">
                <Td @click.stop>
                    <CheckInput 
                        :value="client.id" 
                        :checked="selected.includes(client.id)" 
                        @change="onSelectRow(client.id, $event.target.checked)"
                    />
                </Td>
                <Td>{{ client.firstname }}</Td>
                <Td>{{ client.lastname }}</Td>
                <Td>{{ client.phone_number }}</Td>
                <Td><NumberFormatter :value="client.wallet.balance" currency="XOF" /></Td>
                <Td><ActiveIcon :active="client.active"/></Td>
                <Td><ActiveIcon :active="!client.wallet.is_blocked" /></Td>
                <Td>
                    <SecondaryButton v-if="auth.permissions.includes('show_client')" @click.prevent="router.visit(route('dashboard.clients.show', {id: client.id}))">Voir</SecondaryButton>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.clients.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.clients.meta.links" />
</template>