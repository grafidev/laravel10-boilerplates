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
import Edit from './Edit.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import { ref, watch } from 'vue';

import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import { ArrowsRightLeftIcon } from '@heroicons/vue/24/outline';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import FormCard from '@/Components/FormCard.vue';

const editingTransaction = ref(null);
const showCreate = ref(false);
const props = defineProps({
  transactionTypes: Object, 
  perpage: [String, Number],
  filters: Object,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage, route('dashboard.transaction-types.index'));
};

watch(search, value => {
    router.get(route('dashboard.transaction-types.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteTransactionType = (transactionType) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.transaction-types.destroy', { transaction_type: transactionType.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des types de transaction">
    <template #header>
        <DashboardBreadcrumb title="Gestion des types de transaction">
            <BreadcrumbItem :url="route('dashboard.transaction-types.index')">
                <ArrowsRightLeftIcon class="w-5 h-5 mr-2.5"/> Types de transaction
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <SettingsPartials>
        <SearchWrapper>
            <template #end>
                <SearchField v-model="search" placeholder="Rechercher un type de transaction" />
            </template>
        </SearchWrapper>
    
        <FormCard title="Gestion des types de transaction" :shadow="false">
            <template #actions>
                <PrimaryButton v-if="auth.permissions.includes('create_transaction_type')" @click.prevent="showCreate = true">Créer</PrimaryButton>
                <Create :show="showCreate" @close="showCreate = false"/>
            </template>
            <Table>
                <Thead v-if="props.transactionTypes.data.length">
                    <Tr>
                        <Th><SortableLink label="Nom" attribute="name" /></Th>
                        <Th><SortableLink label="Slug" attribute="slug" /></Th>
                        <Th><SortableLink label="Etat" attribute="active" /></Th>
                        <Th>Actions</th>
                    </Tr>
                </Thead>
                <Tbody>
                    <NoRecords v-if="props.transactionTypes.data.length == 0" title="Aucun type de transaction enregistré" />
                    <Tr v-for="transactionType in props.transactionTypes.data" :key="transactionType.id">
                        <Td>{{ transactionType.name }}</Td>
                        <Td>{{ transactionType.slug }}</Td>
                        <Td><ActiveIcon :active="transactionType.active" /></Td>
                        <Td>
                            <ButtonGroup>
                                <PrimaryButton v-if="auth.permissions.includes('edit_transaction_type')" type="button" @click="editingTransaction = transactionType.id">
                                    Modifier
                                </PrimaryButton>
                                <DangerButton v-if="auth.permissions.includes('delete_transaction_type')" @click.prevent="deleteTransactionType(transactionType)">Supprimer</DangerButton>
                            </ButtonGroup>
                            <Edit :show="editingTransaction == transactionType.id" @close="editingTransaction = null" :transactionType="transactionType" />
                        </Td>
                    </Tr>
                </Tbody>
            </Table>
        </FormCard>
    
        <Pagination :meta="props.transactionTypes.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.transactionTypes.meta.links" />
    </SettingsPartials>
  </DashboardLayout>
</template>