<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Pagination from '@/Components/Pagination.vue';
import { computed, watch, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import SearchField from '@/Components/Forms/SearchField.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import BulkActions from '@/Components/BulkActions.vue';
import { useCheckAll } from '@/composables';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import UserAccountDetails from '@/Components/UserAccountDetails.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';

const props = defineProps({ 
    users: Object, 
    roles: Array, 
    countries: Array, 
    companies: Array, 
    products: Array,
    perpage: [String, Number],
    filters: Object,
});

const search = ref(props.filters.search);
const { auth } = usePage().props;

const onChangePerpage = (perpage) => changePerPage(perpage, route('dashboard.customers.index'));

watch(search, value => {
    router.get(route('dashboard.customers.index'), { search: value }, { preserveState: true, replace: true });
});

const bulkActions = [
    {label: 'Exporter', id: 'export'},
];

const handleBulkAction = (action) => {
    if(action.id == 'export') {
        alert('Export à implémenter...');
    }
};

const { selected, checkAll, onSelectRow } = useCheckAll(props.users.data);
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="handleBulkAction" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un client CARDOIL" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead>
            <Tr>
                <Th>
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Pays" attribute="country.name" /></Th>
                <Th><SortableLink label="Compagnie" attribute="company.name" /></Th>
                <Th><SortableLink label="Statut" attribute="active" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody :animation="false">
            <Tr v-for="user in users.data" :key="user.id">
                <Td class="w-4 p-4">
                    <CheckInput
                        :value="user.id" 
                        :checked="selected.includes(user.id)" 
                        @change="onSelectRow(user.id, $event.target.checked)"
                    />
                </Td>

                <Td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                    <UserAccountDetails :user="user" />
                </Td>
                <Td>{{ user.country?.name }}</Td>
                <Td>{{ user.companies_list }}</Td>
                <Td><ActiveIcon :active="user.active" /></Td>
                <Td>
                    <PrimaryButton v-if="auth.permissions.includes('edit_user')" @click.prevent="router.visit(route('dashboard.customers.edit', { customer: user.id }))" type="button">
                        Modifier
                    </PrimaryButton>
                </Td>
            </Tr>
        </Tbody>
    </Table>

    <Pagination :meta="props.users.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerpage" :links="props.users.meta.links" />
</template>