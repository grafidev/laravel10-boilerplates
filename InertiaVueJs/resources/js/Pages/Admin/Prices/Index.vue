<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Create from './Create.vue';
import Edit from './Edit.vue'
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref, watch } from 'vue';

import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';

const editingPrice = ref(null);
const showCreate = ref(false);
const props = defineProps({
  prices: Object, 
  perpage: [String, Number],
  filters: Object,
  products: Array,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage);
};

watch(search, value => {
    router.get(route('dashboard.prices.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deletePrice = (price) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.prices.destroy', { price: price.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des prix">
    <template #header>
        <DashboardBreadcrumb title="Gestion des prix">
            <li class="inline-flex items-center">
                <Link :href="route('dashboard.settings.create')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                    Configuration
                </Link>
            </li>

            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Gestion des prix</a>
                </div>
            </li>
        </DashboardBreadcrumb>
    </template>

    <template #actions>
        <PrimaryButton v-if="auth.permissions.includes('create_price')" @click.prevent="showCreate = true">Créer</PrimaryButton>
    </template>

    <Create :products="props.products" :show="showCreate" @close="showCreate = false"/>

    <SettingsPartials>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="sm:flex w-full items-center">
                <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <SearchField v-model="search" placeholder="Rechercher..." />
                </div>
            </div>    
        </div>
    
        <Table>
            <Thead v-if="props.prices.data.length">
                <Tr>
                    <Th><SortableLink label="Produit" attribute="product.name" /></Th>
                    <Th><SortableLink label="Prix TTC" attribute="ttc" /></Th>
                    <Th><SortableLink label="Prix HTVA" attribute="htva" /></Th>
                    <Th><SortableLink label="Prix HTT" attribute="htt" /></Th>
                    <Th><SortableLink label="Début" attribute="starts_at" /></Th>
                    <Th><SortableLink label="Fin" attribute="ends_at" /></Th>
                    <Th>Actions</th>
                </Tr>
            </Thead>
    
            <Tbody>
                <NoRecords colspan="6" v-if="props.prices.data.length == 0" title="Aucun prix configuré"/>
                <Tr v-for="price in props.prices.data" :key="price.id">
                    <Td>{{ price.product?.name }}</Td>
                    <Td>{{ price.ttc }}</Td>
                    <Td>{{ price.htva }}</Td>
                    <Td>{{ price.htt }}</Td>
                    <Td>{{ price.starts_at }}</Td>
                    <Td>{{ price.ends_at }}</Td>
                    <Td>
                        <div class="flex items-center gap-2">
                            <PrimaryButton v-if="auth.permissions.includes('edit_price')" type="button" @click="editingPrice = price.id">
                                Modifier
                            </PrimaryButton>
                            <DangerButton v-if="auth.permissions.includes('delete_price')" @click.prevent="deletePrice(price)">Supprimer</DangerButton>
                        </div>
                        <Edit :products="props.products" :show="editingPrice == price.id" @close="editingPrice = null" :price="price" />
                    </Td>
                </Tr>
            </Tbody>
        </Table> 
    
        <Pagination :meta="props.prices.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.prices.meta.links" />
    </SettingsPartials>
  </DashboardLayout>
</template>