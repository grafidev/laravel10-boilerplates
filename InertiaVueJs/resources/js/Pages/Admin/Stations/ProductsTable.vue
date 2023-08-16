s<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import { router, usePage, Link } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditProduct from './EditProduct.vue';

const props    = defineProps({ 
    products: Object, 
    perpage: [String, Number],
    station: Object,
});
const search   = ref('');
const { auth } = usePage().props;
const editingProduct = ref(null);

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.products.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.products.show', { station: props.station.id }), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:flex w-full items-center">
            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <SearchField v-model="search" placeholder="Rechercher un produit" />
            </div>
        </div>    
    </div>

    <Table>
        <Thead v-if="props.products.data.length">
            <Tr>
                <Th><SortableLink label="Nom" attribute="name"/></Th>
                <Th><SortableLink label="Slug" attribute="slug"/></Th>
                <Th><SortableLink label="Prix" attribute="price"/></Th>
                <Th><SortableLink label="Catégorie" attribute="product_category.name"/></Th>
                <Th><SortableLink label="Notes" attribute="note"/></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.products.data.length == 0" title="Aucun produit enregistré" />
            
            <Tr v-for="product in props.products.data" :key="product.id">
                <Td>{{ product.name }}</Td>
                <Td>{{ product.slug }}</Td>
                <Td>{{ product.price }}</Td>
                <Td>{{ product.product_category.name }}</Td>
                <Td>{{ product.note }}</Td>
                <Td>
                    <PrimaryButton @click.prevent="editingProduct = product.id">Modifier</PrimaryButton>
                    <EditProduct :station="props.station" :product="product" :show="editingProduct == product.id" @close="editingProduct = null"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.products.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.products.meta.links" />
</template>