<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Edit from './Edit.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';

const props = defineProps({ 
    permissions: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search = ref(props.filters.search);
const editingPermission = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.permissions.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.permissions.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:flex w-full items-center">
            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <SearchField v-model="search" placeholder="Rechercher une permission" />
            </div>
        </div>    
    </div>

    <Table>
        <Thead>
            <Tr>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Description" attribute="description" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <Tr v-for="permission in permissions.data" :key="permission.id">
                <Td>{{ permission.name }}</Td>
                <Td>{{ permission.description }}</Td>
                <Td>
                    <PrimaryButton v-if="auth.permissions.includes('edit_permission')" type="button" @click="editingPermission = permission.id">
                        Modifier
                    </PrimaryButton>
                    <Edit :show="editingPermission == permission.id" @close="editingPermission = null" :permission="permission" />
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="permissions.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="permissions.meta.links" />
</template>