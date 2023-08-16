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
    alerts: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingAlert = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.alerts.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.alerts.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteAlert = (alert) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.alerts.destroy', { alert: alert.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une alerte" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="alerts.data.length">
            <Tr>
                <Th><SortableLink label="Titre" attribute="title"/></Th>
                <Th><SortableLink label="Description" attribute="description"/></Th>
                <Th><SortableLink label="Type" attribute="type" /></Th>
                <Th><SortableLink label="Date de début" attribute="start_date" /></Th>
                <Th><SortableLink label="Date de fin" attribute="end_date" /></Th>
                <Th><SortableLink label="Fichier" attribute="file"/></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.alerts.data.length == 0" title="Aucune alerte enregistrée" />
            <Tr v-for="alert in props.alerts.data" :key="alert.id">
                <Td>{{ alert.title }}</Td>
                <Td>{{ alert.description }}</Td>
                <Td>{{ alert.type_label }}</Td>
                <Td><DateForHumans :time="false" :date="alert.start_date"/></Td>
                <Td><DateForHumans :time="false" :date="alert.end_date"/></Td>
                <Td>
                    <a href="#"  :title="alert.title" class="text-green-600 underline" target="_blank">Fichier</a>
                </Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingAlert = alert.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteAlert(alert)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingAlert == alert.id" @close="editingAlert = null" :alert="alert"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="alerts.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="alerts.meta.links" />
</template>