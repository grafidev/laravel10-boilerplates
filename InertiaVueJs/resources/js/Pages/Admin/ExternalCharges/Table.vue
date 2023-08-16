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
import DateForHumans from '@/Components/DateForHumans.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props = defineProps({ 
    recharges: Object, 
    perpage: [String, Number],
    filters: Object,
});

const search = ref(props.filters.search);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.external_charges.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.external_charges.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.recharges.data.length">
            <Tr>
                <Th><SortableLink label="Montant" attribute="amount" /></Th>
                <Th><SortableLink label="Utilisateur" attribute="user.name" /></Th>
                <Th><SortableLink label="Role" attribute="roles_name" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th><SortableLink label="Type de recharge" attribute="is_internal" /></Th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords title="Aucune recharge n'a été effectuée" v-if="props.recharges.data.length == 0" />

            <Tr v-for="recharge in props.recharges.data" :key="recharge.id">
                <Td><NumberFormatter :value="recharge.amount" currency="XOF" /></Td>
                <Td>{{ recharge.user.name }}</Td>
                <Td>{{ recharge.user.roles_list }}</Td>
                <Td><DateForHumans :date="recharge.created_at" /></Td>
                <Td>{{ recharge.is_internal ? 'Interne' : 'Externe' }}</Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="recharges.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="recharges.meta.links" />
</template>