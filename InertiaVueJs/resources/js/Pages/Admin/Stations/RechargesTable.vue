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
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ValidateRecharge from './ValidateRecharge.vue';
import RejectRecharge from './RejectRecharge.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import DangerButton from '@/Components/DangerButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import RechargeValidationHistory from './RechargeValidationHistory.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';

const emit = defineEmits(['onChangePerpage']);

const props    = defineProps({ 
    recharges: Object, 
    perpage: [String, Number],
    station: Object,
    rejectionReasons: Array,
});

const search   = ref('');
const { auth } = usePage().props;
const validateRecharge = ref(null);
const rejectRecharge = ref(null);
const showValidationHistory = ref(null);

const onChangePerPage = (page) => {
    emit('onChangePerpage', page);
};

watch(search, (value) => {
    router.get(route('dashboard.station_recharges.index', { station: props.station.id }), { search: value }, {
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
        <Thead v-if="props.recharges?.data.length">
            <Tr>
                <Th><SortableLink label="Montant" attribute="amount" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th><SortableLink label="Statut" attribute="rechargeStatus.name" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.recharges?.data.length == 0" title="Aucune recharge effectuée" />
            
            <Tr v-for="recharge in props.recharges?.data" :key="recharge.id">
                <Td><NumberFormatter :value="recharge.amount" currency="XOF"/></Td>
                <Td><DateForHumans :date="recharge.created_at" /></Td>
                <Td>
                    <StatusBadge v-if="recharge.rechargeStatus?.name" :name="recharge.rechargeStatus?.name">{{ recharge.rechargeStatus?.description }}</StatusBadge>
                    <span v-else>---</span>
                </Td>
                <Td>
                    <ButtonGroup>
                        <PrimaryButton v-if="!recharge.validation_processed" @click.prevent="validateRecharge = recharge.id">Valider</PrimaryButton>
                        <DangerButton v-if="!recharge.validation_processed" @click.prevent="rejectRecharge = recharge.id">Rejeter</DangerButton>
                        <SecondaryButton v-if="recharge.validationHistories.length" @click.prevent="showValidationHistory = recharge.id">Historique de validation</SecondaryButton>
                    </ButtonGroup>

                    <RechargeValidationHistory v-if="recharge.validationHistories.length" :recharge="recharge" :show="showValidationHistory === recharge.id" @close="showValidationHistory = null" />
                    <ValidateRecharge :station="props.station" :recharge="recharge" :show="validateRecharge == recharge.id" @close="validateRecharge = null"/>
                    <RejectRecharge :rejection-reasons="props.rejectionReasons" :station="props.station" :recharge="recharge" :show="rejectRecharge == recharge.id" @close="rejectRecharge = null"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.recharges?.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.recharges?.meta?.links" />
</template>