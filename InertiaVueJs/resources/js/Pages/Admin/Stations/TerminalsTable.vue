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
import ActiveIcon from '@/Components/ActiveIcon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditTerminal from './EditTerminal.vue'
import NumberFormatter from '@/Components/NumberFormatter.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props    = defineProps({ 
    terminals: Object, 
    perpage: [String, Number],
    station: Object,
});
const search   = ref('');
const page = usePage();
const { auth } = page.props;
const editingTerminal = ref(null);

const onChangePerPage = (p) => {
    changePerPage(p, page.url);
};

watch(search, (value) => {
    router.get(route('dashboard.station_terminals.index', { station: props.station.id }), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher un terminal" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.terminals.data.length">
            <Tr>
                <Th><SortableLink label="Prénom" attribute="firstname" /></Th>
                <Th><SortableLink label="Nom de famille" attribute="lastname" /></Th>
                <Th><SortableLink label="Adresse email" attribute="email" /></Th>
                <Th><SortableLink label="Numéro de téléphone" attribute="phone_number" /></Th>
                <Th><SortableLink label="Solde" attribute="wallet.balance" /></Th>
                <Th><SortableLink label="Marque" attribute="terminalInfo.brand" /></Th>
                <Th><SortableLink label="Modèle" attribute="terminalInfo.model" /></Th>
                <Th><SortableLink label="Numéro de série" attribute="terminalInfo.serial_number" /></Th>
                <Th><SortableLink label="Etat du compte" attribute="active" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.terminals.data.length == 0" title="Aucun terminal enregistré" />
            
            <Tr v-for="terminal in props.terminals.data" :key="terminal.id">
                <Td>{{ terminal.firstname }}</Td>
                <Td>{{ terminal.lastname }}</Td>
                <Td>{{ terminal.email }}</Td>
                <Td>{{ terminal.phone_number }}</Td>
                <Td><NumberFormatter :value="terminal.wallet?.balance || 0" currency="XOF"/></Td>
                <Td>{{ terminal.terminalInfo?.brand }}</Td>
                <Td>{{ terminal.terminalInfo?.model }}</Td>
                <Td>{{ terminal.terminalInfo?.serial_number }}</Td>
                <Td>
                    <ActiveIcon :active="terminal.active"/>
                </Td>
                <Td>
                    <PrimaryButton @click.prevent="editingTerminal = terminal.id">Modifier</PrimaryButton>
                    <EditTerminal :station="props.station" :terminal="terminal" :show="editingTerminal == terminal.id" @close="editingTerminal = null"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.terminals.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.terminals.meta.links" />
</template>