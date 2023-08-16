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
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { ref, watch } from 'vue';

import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';

const editingCard = ref(null);
const showCreate = ref(false);
const props = defineProps({
  cards: Object, 
  perpage: [String, Number],
  filters: Object,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage);
};

watch(search, value => {
    router.get(route('dashboard.cards.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteCard = (card) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.cards.destroy', { card: card.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des cartes">
    <template #header>
        <DashboardBreadcrumb title="Gestion des cartes">
            <li class="inline-flex items-center">
                <Link :href="route('dashboard.settings.create')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                    Configuration
                </Link>
            </li>

            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Gestion des cartes</a>
                </div>
            </li>
        </DashboardBreadcrumb>
    </template>

    <template #actions>
        <PrimaryButton v-if="auth.permissions.includes('create_card')" @click.prevent="showCreate = true">Créer</PrimaryButton>
    </template>

    <Create :show="showCreate" @close="showCreate = false"/>

    <SettingsPartials>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="sm:flex w-full items-center">
                <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <SearchField v-model="search" placeholder="Rechercher une carte" />
                </div>
            </div>    
        </div>
    
        <Table>
            <Thead v-if="props.cards.data.length">
                <Tr>
                    <Th><SortableLink label="Nom" attribute="numCarte" /></Th>
                    <Th><SortableLink label="Statut" attribute="isBlocked" /></Th>
                    <Th>Actions</th>
                </Tr>
            </Thead>
    
            <Tbody>
                <NoRecords colspan="3" v-if="props.cards.data.length == 0" title="Aucune carte enregistrée"/>
                <Tr v-for="card in props.cards.data" :key="card.id">
                    <Td>{{ card.numCarte }}</Td>
                    <Td><ActiveIcon :active="!card.isBlocked"/></Td>
                    <Td>
                        <div class="flex items-center gap-2">
                            <PrimaryButton v-if="auth.permissions.includes('edit_card')" type="button" @click="editingCard = card.id">
                                Modifier
                            </PrimaryButton>
                            <DangerButton v-if="auth.permissions.includes('delete_card')" @click.prevent="deleteCard(card)">Supprimer</DangerButton>
                        </div>
                        <Edit :show="editingCard == card.id" @close="editingCard = null" :card="card" />
                    </Td>
                </Tr>
            </Tbody>
        </Table> 
    
        <Pagination :meta="props.cards.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.cards.meta.links" />
    </SettingsPartials>
  </DashboardLayout>
</template>