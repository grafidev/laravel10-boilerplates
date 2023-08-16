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
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { ref, watch } from 'vue';

import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import FormCard from '@/Components/FormCard.vue';

const editingCompany = ref(null);
const showCreate = ref(false);
const props = defineProps({
  companies: Object, 
  perpage: [String, Number],
  filters: Object,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage);
};

watch(search, value => {
    router.get(route('dashboard.companies.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteCompany = (company) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.companies.destroy', { company: company.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des compagnies">
    <template #header>
        <DashboardBreadcrumb title="Gestion des compagnies">
            <BreadcrumbItem :url="route('dashboard.companies.index')">
                <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Compagnies
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <SettingsPartials>
        <SearchWrapper>
            <template #end>
                <SearchField v-model="search" placeholder="Rechercher une compagnie" />
            </template>
        </SearchWrapper>
        
        <FormCard title="Gestion des compagnies" :shadow="false">
            <template #actions>
                <PrimaryButton v-if="auth.permissions.includes('create_company')" @click.prevent="showCreate = true">Créer</PrimaryButton>
                <Create :show="showCreate" @close="showCreate = false"/>
            </template>
            
            <Table>
                <Thead v-if="props.companies.data.length">
                    <Tr>
                        <Th><SortableLink label="Nom" attribute="name" /></Th>
                        <Th><SortableLink label="Logo" attribute="logo" /></Th>
                        <Th><SortableLink label="Etat" attribute="active" /></Th>
                        <Th>Actions</th>
                    </Tr>
                </Thead>
    
                <Tbody>
                    <NoRecords colspan="3" v-if="props.companies.data.length == 0" title="Aucune compagnie enregistrée"/>
                    <Tr v-for="company in props.companies.data" :key="company.id">
                        <Td>{{ company.name }}</Td>
                        <Td><img class="w-12 h-12 object-contain" :src="company.logo_url"/></Td>
                        <Td><ActiveIcon :active="company.active"/></Td>
                        <Td>
                            <ButtonGroup>
                                <PrimaryButton v-if="auth.permissions.includes('edit_company')" type="button" @click="editingCompany = company.id">
                                    Modifier
                                </PrimaryButton>
                                <DangerButton v-if="auth.permissions.includes('delete_company')" @click.prevent="deleteCompany(company)">Supprimer</DangerButton>
                            </ButtonGroup>
                            <Edit :stations="props.stations" :countries="countries" :show="editingCompany == company.id" @close="editingCompany = null" :company="company" />
                        </Td>
                    </Tr>
                </Tbody>
            </Table> 
        </FormCard>
    
        <Pagination :meta="props.companies.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.companies.meta.links" />
    </SettingsPartials>
  </DashboardLayout>
</template>