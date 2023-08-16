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
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue'
import FormCard from '@/Components/FormCard.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { ref, watch } from 'vue';

import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import { ShoppingCartIcon } from '@heroicons/vue/24/outline';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const editingProduct = ref(null);
const showCreate = ref(false);
const props = defineProps({
  products: Object, 
  perpage: [String, Number],
  categories: Array,
  filters: Object,
  stations: Array,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage);
};

watch(search, value => {
    router.get(route('dashboard.settings.products.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteProduct = (product) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.settings.products.destroy', { product: product.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des produits">
    <template #header>
        <DashboardBreadcrumb title="Gestion des produits">
            <BreadcrumbItem :url="route('dashboard.products.index')">
                <ShoppingCartIcon class="w-5 h-5 mr-2.5"/> Produits
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <SettingsPartials>
        <SearchWrapper>
            <template #end>
                <SearchField v-model="search" placeholder="Rechercher un produit" />
            </template>
        </SearchWrapper>

        <FormCard title="Gestion des produits" :shadow="false">
            <template #actions>
                <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
                <Create :stations="props.stations" :categories="props.categories" :show="showCreate" @close="showCreate = false"/>
            </template>

            <Table>
                <Thead v-if="props.products.data.length">
                    <Tr>
                        <Th><SortableLink label="Nom" attribute="name" /></Th>
                        <Th><SortableLink label="Slug" attribute="slug" /></Th>
                        <Th><SortableLink label="Etat" attribute="active" /></Th>
                        <Th>Actions</th>
                    </Tr>
                </Thead>
    
                <Tbody>
                    <NoRecords v-if="props.products.data.length == 0" title="Aucun produit enregistré"/>
                    <Tr v-for="product in props.products.data" :key="product.id">
                        <Td>{{ product.name }}</Td>
                        <Td>{{ product.slug }}</Td>
                        <Td>
                            <ActiveIcon :active="product.active"/>
                        </Td>
                        <Td>
                            <ButtonGroup>
                                <PrimaryButton v-if="auth.permissions.includes('edit_product')" type="button" @click.prevent="editingProduct = product.id">Modifier</PrimaryButton>
                                <DangerButton variant="red" v-if="auth.permissions.includes('delete_product')" @click.prevent="deleteProduct(product)">Supprimer</DangerButton>
                            </ButtonGroup>
                            <Edit :stations="props.stations" :categories="props.categories" :show="editingProduct == product.id" @close="editingProduct = null" :product="product" />
                        </Td>
                    </Tr>
                </Tbody>
            </Table> 
        </FormCard>

        <Pagination :meta="props.products.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.products.meta.links" />
    </SettingsPartials>
  </DashboardLayout>
</template>