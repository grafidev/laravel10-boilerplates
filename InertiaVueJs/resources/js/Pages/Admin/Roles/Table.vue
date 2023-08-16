<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props = defineProps({ 
    roles: Object, 
    permissions: Array, 
    perpage: [String, Number],
    filters: Object,
});

const search = ref(props.filters.search);
const { auth } = usePage().props;

const onChangePerpage = page => {
    changePerPage(page, route('dashboard.roles.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.roles.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher"/>
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.roles.data.length">
            <Tr>
                <Th><SortableLink label="Nom" attribute="description" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords title="Aucun rôle configuré" v-if="props.roles.data.length === 0" />

            <Tr v-for="role in roles.data" :key="role.id">
                <Td>{{ role.description }}</Td>
                <Td>
                    <PrimaryButton v-if="auth.permissions.includes('edit_role')" @click.prevent="router.visit(route('dashboard.roles.edit', {role: role.id}))">
                        Modifier
                    </PrimaryButton>
                </Td>
            </Tr>
        </Tbody>
    </Table>

    <Pagination :meta="roles.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerpage" :links="roles.meta.links" />
</template>