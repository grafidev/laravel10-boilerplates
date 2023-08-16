<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed, ref, watch } from 'vue';
import { router, usePage, useForm } from '@inertiajs/vue3';
import { changePerPage, exportData } from '@/utils';
import NoRecords from '@/Components/NoRecords.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { getFiltersCount, useCheckAll } from '@/composables';
import BulkActions from '@/Components/BulkActions.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import TransactionDetailsModal from '@/Pages/Admin/Transactions/TransactionDetailsModal.vue';
import Modal from '@/Components/Modal.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import CancellationRequestValidationForm from './CancellationRequestValidationForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ModalContent from '@/Components/ModalContent.vue';
import UserDetails from '../Clients/UserDetails.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const props = defineProps({ 
    perpage: [String, Number],
    filters: Object,
    cancellation_requests: Object, 
});

const page     = usePage();
const { auth } = page.props;

const showingTransaction = ref(null);
const showingUserDetails = ref(null);
const processingCancellationRequest = ref(null);

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.cancellation_requests.index'));
};

const filterForm = useForm({
    search: props.filters.search,
});

const filtersCount = computed(() => getFiltersCount(filterForm))
const filtering = computed(() => filtersCount.value > 0);

for(const key in filterForm.data()) {
    watch(() => filterForm[key], value => {
        router.get(page.url, { ...props.filters, [key]: value }, { preserveState: true, replace: true });
    });
}

watch(() => filterForm.search, (value) => {
    router.get(page.url, { search: value }, { preserveState: true, replace: true });
});

const { selected, checkAll, onSelectRow } = useCheckAll(props.cancellation_requests.data);

const bulkActions = [
    { label: 'Exporter', id: 'export' }, 
];

const onHandleBulkAction = action => {
    if(action.id === 'export') {
        alert('TODO: export cancellation_requests');
    }
};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="onHandleBulkAction" />
        </template>
        <template #end>
            <SearchField v-model="filterForm.search" placeholder="Rechercher une demande..." />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.cancellation_requests.data.length">
            <Tr>
                <Th><CheckInput v-model="checkAll" /></Th>
                <Th><SortableLink label="Transaction" attribute="transaction.transaction_reference"/></th>
                <Th><SortableLink label="Demandeur" attribute="user.name"/></th>
                <Th><SortableLink label="Montant à annuler" attribute="transaction.amount"/></th>
                <Th><SortableLink label="Statut" attribute="cancellation_request_status.name"/></th>
                <Th><SortableLink label="Date de demande" attribute="created_at"/></th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.cancellation_requests.data.length == 0" title="Aucune demande d'annulation enregistrée" />

            <Tr v-for="cancellation_request in props.cancellation_requests.data" :key="cancellation_request.id">
                <Td class="w-4 p-4" @click.stop>
                    <CheckInput
                        :value="cancellation_request.id"
                        :checked="selected.includes(cancellation_request.id)" 
                        @change="onSelectRow(cancellation_request.id, $event.target.checked)" 
                    />
                </Td>
                <Td>
                    <a href="#" @click.prevent="showingTransaction = cancellation_request.transaction.id" class="text-green-500 underline">
                        {{ cancellation_request.transaction.transaction_reference }}
                    </a>
                    <TransactionDetailsModal :show="showingTransaction == cancellation_request.transaction.id" @close="showingTransaction = null" :transaction="cancellation_request.transaction" />
                </Td>
                <Td>
                    <a href="#" @click.prevent="showingUserDetails = cancellation_request.user.id" class="text-green-500 underline">{{ cancellation_request.user.name }}</a>   
                    <Modal :show="showingUserDetails == cancellation_request.user.id" @close="showingUserDetails = null">
                        <ModalContent :title="`À propos de ${cancellation_request.user.name}`" @close="showingUserDetails = null">
                            <UserDetails :user="cancellation_request.user" />
                        </ModalContent>
                    </Modal>
                </Td>
                <Td><NumberFormatter :value="cancellation_request.transaction.amount" currency="XOF"/></Td>
                <Td><StatusBadge :name="cancellation_request.cancellation_request_status.name">{{ cancellation_request.cancellation_request_status.description }}</StatusBadge></Td>
                <Td><DateForHumans :date="cancellation_request.created_at" /></Td>
                <Td>
                    <SecondaryButton v-if="!cancellation_request.transaction.cancelled" @click.prevent="processingCancellationRequest = cancellation_request.id">Traiter</SecondaryButton>
                    <PrimaryButton v-else @click.prevent="showingTransaction = cancellation_request.transaction.id">Voir la transaction annulée</PrimaryButton>
                    <CancellationRequestValidationForm 
                        :cancellation_request="cancellation_request" 
                        :show="processingCancellationRequest == cancellation_request.id" 
                        @close="processingCancellationRequest = null"
                    />
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.cancellation_requests.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.cancellation_requests.meta.links" />
</template>