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
import { router, usePage, Link } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';

const props    = defineProps({ terminals: Object, perpage: [String, Number] })
const search   = ref('');
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.terminals.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.terminals.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:flex w-full items-center">
            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <SearchField v-model="search" placeholder="Rechercher un terminal" />
            </div>
        </div>    
    </div>

    <Table>
        <Thead v-if="props.terminals.data.length">
            <Tr>
                <Th><SortableLink label="Prénom" attribute="firstname" /></Th>
                <Th><SortableLink label="Nom de famille" attribute="lastname" /></Th>
                <Th><SortableLink label="Numéro de téléphone" attribute="phone_number" /></Th>
                <Th><SortableLink label="Etat du compte" attribute="active" /></Th>
                <Th><SortableLink label="Station" attribute="station.name" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.terminals.data.length == 0" title="Aucun pompiste enregistré" />
            
            <Tr v-for="terminal in props.terminals.data" :key="terminal.id">
                <Td>{{ terminal.firstname }}</Td>
                <Td>{{ terminal.lastname }}</Td>
                <Td>{{ terminal.phone_number }}</Td>
                <Td>
                    <ActiveIcon :active="terminal.active"/>
                </Td>
                <Td>{{ terminal.station?.name }}</Td>
                <Td>
                    <ButtonGroup>
                        <ButtonLink outline :href="route('dashboard.terminals.show', {terminal: terminal.id})">Voir</ButtonLink>
                        <ButtonLink :href="route('dashboard.terminals.edit', {terminal: terminal.id})">Modifier</ButtonLink>
                    </ButtonGroup>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.terminals.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="terminals.meta.links" />
</template>