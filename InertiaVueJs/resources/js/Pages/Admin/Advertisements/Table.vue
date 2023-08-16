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
import OpenUrl from '@/Components/OpenUrl.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props    = defineProps({ 
    advertisements: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search   = ref(props.filters.search);
const editingAdvertisement = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.advertisements.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.advertisements.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteAdvertisement = (advertisement) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.advertisements.destroy', { advertisement: advertisement.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};

const openUrl = (url) => {
    window.open(url);
};
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une publication" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="advertisements.data.length">
            <Tr>
                <Th><SortableLink label="Titre" attribute="title"/></Th>
                <Th><SortableLink label="Description" attribute="description"/></Th>
                <Th><SortableLink label="Type" attribute="type"/></Th>
                <Th><SortableLink label="Date de début" attribute="start_date"/></Th>
                <Th><SortableLink label="Date de fin" attribute="end_date"/></Th>
                <Th><SortableLink label="Fichier" attribute="file"/></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.advertisements.data.length == 0" title="Aucune publication enregistrée" />
            <Tr v-for="advertisement in props.advertisements.data" :key="advertisement.id">
                <Td>{{ advertisement.title }}</Td>
                <Td>{{ advertisement.description }}</Td>
                <Td>{{ advertisement.type_label }}</Td>
                <Td><DateForHumans :time="false" :date="advertisement.start_date"/></Td>
                <Td><DateForHumans :time="false" :date="advertisement.end_date"/></Td>
                <Td>
                    <OpenUrl v-if="advertisement.type !== 'text'" :url="advertisement.file_url">Fichier</OpenUrl>
                </Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton @click.prevent="editingAdvertisement = advertisement.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteAdvertisement(advertisement)">Supprimer</DangerButton>
                    </div>
                    <Edit :show="editingAdvertisement == advertisement.id" @close="editingAdvertisement = null" :advertisement="advertisement"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="advertisements.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="advertisements.meta.links" />
</template>