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
import SortableLink from '@/Components/Table/SortableLink.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import ConfiguredPricesModal from './ConfiguredPricesModal.vue';

const props = defineProps({
    products: Object,
    filters: Object,
    perpage: [String, Number],
});

const search = ref(props.filters.search);
const showConfiguredPrices = ref(null);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => changePerPage(perpage, route('dashboard.products.index'));

watch(search, value => {
    router.get(route('dashboard.products.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un produit" />
        </template>
    </SearchWrapper>
    
    <Table>
        <Thead v-if="props.products.data.length">
            <Tr>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Slug" attribute="slug" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.products.data.length == 0" title="Aucun produit enregistré"/>
            <Tr v-for="product in props.products.data" :key="product.id">
                <Td>{{ product.name }}</Td>
                <Td>{{ product.slug }}</Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton @click.prevent="showConfiguredPrices = product.id">Prix configurés</SecondaryButton>
                        <SecondaryButton @click.prevent="router.visit(route('dashboard.products.show', { product: product.id }))" variant="blue" v-if="auth.permissions.includes('show_product')" type="button">Configuration de prix</SecondaryButton>
                        <ConfiguredPricesModal :product="product" :show="showConfiguredPrices == product.id" @close="showConfiguredPrices = null" />
                    </ButtonGroup>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.products.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.products.meta.links" />
</template>