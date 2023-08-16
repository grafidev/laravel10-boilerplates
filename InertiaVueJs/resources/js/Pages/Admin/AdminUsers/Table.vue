<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Pagination from '@/Components/Pagination.vue';
import { watch, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import SearchField from '@/Components/Forms/SearchField.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import NoRecords from '@/Components/NoRecords.vue';
import UserAccountDetails from '@/Components/UserAccountDetails.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import { useCheckAll } from '@/composables';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import BulkActions from '@/Components/BulkActions.vue';

const props = defineProps({ 
    users: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const { checkAll, selected, onSelectRow } = useCheckAll(props.users.data);

const onChangePerpage = (perpage) => changePerPage(perpage, route('dashboard.users.index'));

watch(search, (value) => {
    router.get(route('dashboard.users.index'), { search: value }, { preserveState: true, replace: true });
});

const bulkActions = [
    { label: 'Exporter', id: 'export' },
];
const handleBulkAction = ({ id }) => {
    if(id === 'export') {
        alert('Export');
    }
};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length > 0" :actions="bulkActions" @handle="handleBulkAction" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un utilisateur" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.users.data.length"> 
            <Tr>
                <Th><CheckInput v-model="checkAll"/></Th>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th>Role(s)</Th>
                <Th><SortableLink label="Statut" attribute="active" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody :animation="false">
            <NoRecords v-if="props.users.data.length == 0" title="Aucun compte utilisateur créé" />
            <Tr v-for="user in props.users.data" :key="user.id">
                <Td class="w-4 p-4">
                    <CheckInput
                        :value="user.id"
                        :checked="selected.includes(user.id)" 
                        @change="onSelectRow(user.id, $event.target.checked)" 
                    />
                </Td>

                <Td><UserAccountDetails :user="user" /></Td>
                <Td>{{ user.roles_list }}</Td>
                <Td><ActiveIcon :active="user.active" /></Td>
                <Td>
                    <PrimaryButton v-if="auth.permissions.includes('edit_user')" @click.prevent="router.visit(route('dashboard.users.edit', { user: user.id }))" type="button">
                        Modifier
                    </PrimaryButton>
                </Td>
            </Tr>
        </Tbody>
    </Table>

    <Pagination :meta="props.users.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerpage" :links="props.users.meta.links" />
</template>