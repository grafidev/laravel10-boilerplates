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

import Edit from './Edit.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import Modal from '@/Components/Modal.vue';

import CheckInput from '@/Components/Forms/CheckInput.vue';
import ModalContent from '@/Components/ModalContent.vue';
import UserDetails from '../Clients/UserDetails.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import { router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const props = defineProps({
    filters: Object,
    perpage: [String, Number],
    stations: Object,
    regions: Object,
});

const { auth } = usePage().props;

const editingStation = ref(null);
const showingUserDetails = ref(null);
const search = ref(props.filters.search);
const { selected, checkAll, onSelectRow } = useCheckAll(props.stations.data);

watch(search, value => {
    router.get(route('dashboard.stations.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const onChangePerPage = perpage => changePerPage(perpage, route('dashboard.stations.index'));
const deleteStation = (station) => Alert.confirm('Êtes vous sûr ?').then(result => {
    if(result.isConfirmed) {
        router.delete(route('dashboard.stations.destroy', { station: station.id }), {
            onSuccess: () => Alert.success('Suppression effectuée avec succès.')
        });
    }
});

const bulkActions = [
    { label: 'Exporter', id: 'export' },
];

const handleBulkActions = ({ id }) => {
    if(id === 'export') {
        alert('Export à implémenter...');
    }
};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="handleBulkActions" />
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une station service" />
        </template>
    </SearchWrapper>
    
    <Table>
        <Thead v-if="props.stations.data.length">
            <Tr>
                <Th class="w-4 p-4">
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Numéro de téléphone (station)" attribute="phone_number" /></Th>
                <Th><SortableLink label="Région" attribute="region" /></Th>
                <Th>Ventes totales</Th>
                <Th>Gérant</Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords colspan="2" v-if="props.stations.data.length == 0" title="Aucune station service enregistrée"/>

            <Tr v-for="station in props.stations.data" :key="station.id">
                <Td class="w-4 p-4">
                    <CheckInput
                        :value="station.id" 
                        :checked="selected.includes(station.id)" 
                        @change="onSelectRow(station.id, $event.target.checked)" 
                    />
                </Td>
                <Td>{{ station.name }}</Td>
                <Td>{{ station.phone_number }}</Td>
                <Td>{{ station.region }}</Td>
                <Td><NumberFormatter :value="station.total_sales" currency="XOF"/></Td>
                <Td>
                    <div v-if="station.manager">
                        <a href="#" @click.prevent="showingUserDetails = station.manager.id" class="text-green-500 underline">{{ station.manager.name }}</a>   

                        <Modal :show="showingUserDetails == station.manager?.id" @close="showingUserDetails = null">
                            <ModalContent :title="`À propos de ${station.manager.name}`" @close="showingUserDetails = null">
                                <UserDetails :user="station.manager" />
                            </ModalContent>
                        </Modal>
                    </div>
                    <span v-else>---</span>
                </Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton @click.prevent="router.visit(route('dashboard.stations.show', { station: station.id }))" v-if="auth.permissions.includes('show_station')" type="button">
                            Voir
                        </SecondaryButton>
                        <PrimaryButton v-if="auth.permissions.includes('edit_station')" @click.prevent="editingStation = station.id">
                            Modifier
                        </PrimaryButton>
                        <DangerButton v-if="auth.permissions.includes('delete_station')" @click.prevent="deleteStation(station)">Supprimer</DangerButton>
                    </ButtonGroup>
                    <Edit :regions="regions" :show="editingStation == station.id" @close="editingStation = null" :station="station" />
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.stations?.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.stations.meta?.links" />
</template>