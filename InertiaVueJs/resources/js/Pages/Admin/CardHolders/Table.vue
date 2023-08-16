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
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import Modal from '@/Components/Modal.vue';
import CardHolderDetails from './CardHolderDetails.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import { useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';


const props    = defineProps({ 
    cardHolders: Object, 
    perpage: [String, Number],
    filters: Object,
})
const search   = ref(props.filters.search);
const { auth } = usePage().props;
const showingCardHolderDetails = ref(null);

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.card_holders.index'));
};

watch(search, (value) => {
    router.get(route('dashboard.card_holders.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const { selected, checkAll, onSelectRow } = useCheckAll(props.cardHolders.data);
const bulkActions = [
    { label: 'Exporter', id: 'export' }
];
const handleBulkActions = action => {
    if(action.id === 'export') {
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
            <SearchField v-model="search" placeholder="Rechercher un porteur de carte" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.cardHolders.data.length">
            <Tr>
                <Th>
                    <CheckInput v-model="checkAll" />
                </Th>
                <Th><SortableLink label="Nom" attribute="name" /></Th>
                <Th><SortableLink label="Solde" attribute="card.balance" /></Th>
                <Th><SortableLink label="Etat de la carte" attribute="card.is_blocked" /></Th>
                <Th>Actions</Th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.cardHolders.data.length == 0" title="Aucun porteur de carte enregistré" />

            <Tr v-for="card_holder in props.cardHolders.data" :key="card_holder.id">
                <Td>
                    <CheckInput
                        :value="card_holder.id" 
                        :checked="selected.includes(card_holder.id)" 
                        @change="onSelectRow(card_holder.id, $event.target.checked)" 
                    />
                </Td>
                <Td>
                    <div v-if="card_holder">
                        <a href="" @click.prevent="showingCardHolderDetails = card_holder.id" class="text-green-500 underline">{{ card_holder.name }}</a>   
                        <Modal :show="showingCardHolderDetails == card_holder.id" @close="showingCardHolderDetails = null">
                            <div class="p-6">
                                <h2 class="text-lg font-extrabold text-gray-900 dark:text-white mb-7">
                                    À propos de {{ card_holder.name }} 
                                </h2>
                                <CardHolderDetails :user="card_holder" />
                            </div>
                        </Modal>
                    </div>
                    <span v-else>---</span>
                </Td>
                <Td>
                    <NumberFormatter :value="card_holder.card.balance" currency="XOF"/>
                </Td>
                <Td><ActiveIcon :active="!card_holder.card.is_blocked" /></Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton @click.prevent="router.visit(route('dashboard.card_holders.show', { card_holder: card_holder.id }))">Voir</SecondaryButton>
                        <PrimaryButton @click.prevent="router.visit(route('dashboard.card_holders.validationForm', { card_holder: card_holder.id }))">Validation</PrimaryButton>
                    </ButtonGroup>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.cardHolders.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.cardHolders.meta.links" />
</template>