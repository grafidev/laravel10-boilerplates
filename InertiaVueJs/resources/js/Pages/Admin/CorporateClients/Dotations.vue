<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';

import CorporateClientTabs from './CorporateClientTabs.vue';
import { changePerPage } from '@/utils';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Th from '@/Components/Table/Th.vue';
import Td from '@/Components/Table/Td.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CreateDotationValue from './CreateDotationValue.vue';
import EditDotationValue from './EditDotationValue.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { Alert } from '@/alert';

const { auth } = usePage().props;

const filterForm = useForm({
    search: '',
});

const createDotationValue = ref(false);
const editingDotationValue = ref(null);

const props = defineProps({
    corporateClient: Object,
    dotationValues: Object,
    perpage: [String, Number],
});

watch(() => filterForm.search, value => {
    router.get(route('dashboard.corporate_client_dotations.index', { corporate_client: props.corporateClient.data.id }), { search: value }, {
        preserveScroll: true,
        preserveState: true,
    });
});

const deleteDotationValue = (dotationValue) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?', result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.dotationValues.destroy', { dotationValue: dotationValue.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};

const onChangePerpage = page => {
    changePerPage(page, route('dashboard.corporate_client_dotations.index', { corporate_client: props.corporateClient.data.id }));
};
</script>

<template>
    <DashboardLayout title="Dotations">
        <template #header>
            <DashboardBreadcrumb title="Dotations">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.corporate_clients.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <BuildingOffice2Icon class="w-5 h-5 mr-2.5" />
                        Dotations
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ props.corporateClient.data.name }}</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>

        <div class="space-y-2">
            <CorporateClientTabs :corporate-client="props.corporateClient.data">
                <FormCard title="Valeurs dotations">
                    <template #actions>
                        <PrimaryButton @click.prevent="createDotationValue = true">Ajouter</PrimaryButton>
                    </template>

                    <CreateDotationValue :show="createDotationValue" @close="createDotationValue = false" />

                    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                        <div class="sm:flex w-full items-center">
                            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                                <SearchField v-model="filterForm.search" placeholder="Rechercher" />
                            </div>
                        </div>    
                    </div>

                    <Table>
                        <Thead v-if="props.dotationValues.data.length">
                            <Tr>
                                <Th><SortableLink label="Valeur" attribute="name" /></Th>
                                <Th><SortableLink label="Etat" attribute="active" /></Th>
                                <Th>Actions</th>
                            </Tr>
                        </Thead>

                        <Tbody>
                            <NoRecords v-if="props.dotationValues.data.length == 0" title="Aucune valeur de dotation enregistrée" />
                            <Tr v-for="dotationValue in props.dotationValues.data" :key="dotationValue.id">
                                <Td>{{ dotationValue.value }}</Td>
                                <Td><ActiveIcon :active="dotationValue.active" /></Td>
                                <Td>
                                    <div class="flex items-center gap-2">
                                        <PrimaryButton @click.prevent="editingDotationValue = dotationValue.id">Modifier</PrimaryButton>
                                        <DangerButton @click.prevent="deleteDotationValue(dotationValue)">Supprimer</DangerButton>
                                    </div>
                                    <EditDotationValue :show="editingDotationValue == dotationValue.id" @close="editingDotationValue = null" :dotation-value="dotationValue"/>
                                </Td>
                            </Tr>
                        </Tbody>
                    </Table> 
                    
                    <Pagination :meta="props.dotationValues.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerpage" :links="props.dotationValues.meta.links" />
                </FormCard>
            </CorporateClientTabs>
        </div>
    </DashboardLayout>
</template>