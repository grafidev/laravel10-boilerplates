<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import Edit from './Edit.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Alert } from '@/alert';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const props = defineProps({ 
    fidelityPoints: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingFidelityPoint = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.fidelity_points.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.fidelity_points.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteFidelityPoint = (fidelity_point) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.fidelity_points.destroy', { fidelity_point: fidelity_point.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.fidelityPoints.data.length">
            <Tr>
                <Th><SortableLink label="Points requis" attribute="points_required" /></Th>
                <Th><SortableLink label="Valeur" attribute="fidelity_value" /></Th>
                <Th><SortableLink label="Etat" attribute="active" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.fidelityPoints.data.length == 0" title="Aucun point de fidélité enregistré" />
            <Tr v-for="fidelityPoint in props.fidelityPoints.data" :key="fidelityPoint.id">
                <Td>{{ fidelityPoint.points_required }}</Td>
                <Td><NumberFormatter :value="fidelityPoint.fidelity_value" currency="XOF"/></Td>
                <Td><ActiveIcon :active="fidelityPoint.active" /></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingFidelityPoint = fidelityPoint.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteFidelityPoint(fidelityPoint)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingFidelityPoint == fidelityPoint.id" @close="editingFidelityPoint = null" :fidelity_point="fidelityPoint"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.fidelityPoints.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.fidelityPoints.meta.links" />
</template>