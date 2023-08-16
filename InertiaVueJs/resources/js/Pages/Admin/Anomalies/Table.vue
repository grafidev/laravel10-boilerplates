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
import DateForHumans from '@/Components/DateForHumans.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props    = defineProps({ 
    anomalies: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingAnomaly = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.anomalies.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.anomalies.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteAnomaly = (anomaly) => Alert.confirm('Êtes vous sûr de supprimer ceci ?', result => {
    if(result.isConfirmed) {
        router.delete(route('dashboard.anomalies.destroy', { anomaly: anomaly.id }), {
            onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
        });
    }
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une anomalie" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="anomalies.data.length">
            <Tr>
                <Th><SortableLink label="Libellé" attribute="label" /></Th>
                <Th><SortableLink label="Date" attribute="date_of_finding" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="anomalies.data.length == 0" title="Aucune anomalie enregistrée" />
            <Tr v-for="anomaly in anomalies.data" :key="anomaly.id">
                <Td>{{ anomaly.label }}</Td>
                <Td><DateForHumans :date="anomaly.date_of_finding" :time="false"/></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingAnomaly = anomaly.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteAnomaly(anomaly)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingAnomaly == anomaly.id" @close="editingAnomaly = null" :anomaly="anomaly"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="anomalies.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="anomalies.meta.links" />
</template>