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
import ActiveIcon from '@/Components/ActiveIcon.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props    = defineProps({ 
    rejectionReasons: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingRejectionReason = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.rejectionReasons.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.rejectionReasons.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteRejectionReason = (rejectionReason) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?', result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.rejectionReasons.destroy', { rejectionReason: rejectionReason.id }), {
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
        <Thead v-if="props.rejectionReasons.data.length">
            <Tr>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Description" attribute="description" /></Th>
                <Th><SortableLink label="Etat" attribute="active" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.rejectionReasons.data.length == 0" title="Aucun motif de rejet enregistré" />
            <Tr v-for="rejectionReason in props.rejectionReasons.data" :key="rejectionReason.id">
                <Td>{{ rejectionReason.name }}</Td>
                <Td>{{ rejectionReason.description }}</Td>
                <Td><ActiveIcon :active="rejectionReason.active"/></Td>
                <Td><DateForHumans :date="rejectionReason.created_at" /></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingRejectionReason = rejectionReason.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteRejectionReason(rejectionReason)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingRejectionReason == rejectionReason.id" @close="editingRejectionReason = null" :rejection-reason="rejectionReason"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.rejectionReasons.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.rejectionReasons.meta.links" />
</template>