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

const props    = defineProps({ 
    dotationValues: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingDotationValue = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.dotationValues.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.dotationValues.index'), { search: value }, {
        preserveState: true,
        replace: true,
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
</script>

<template>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:flex w-full items-center">
            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <SearchField v-model="search" placeholder="Rechercher" />
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
                <Td><ActiveIcon :active="dotationValue.active"/></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingDotationValue = dotationValue.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteDotationValue(dotationValue)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingDotationValue == dotationValue.id" @close="editingDotationValue = null" :dotation-value="dotationValue"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.dotationValues.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.dotationValues.meta.links" />
</template>