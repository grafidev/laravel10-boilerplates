<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tr from '@/Components/Table/Tr.vue';
import Th from '@/Components/Table/Th.vue';
import Td from '@/Components/Table/Td.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import { Link } from '@inertiajs/vue3';
import { UserIcon } from '@heroicons/vue/24/outline';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import NoRecords from '@/Components/NoRecords.vue';
import { ref } from 'vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import EndowmentValidationForm from './EndowmentValidationForm.vue';
import EndowmentValidationHistory from './EndowmentValidationHistory.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    cardHolder: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const showValidationForm = ref(null);
const showValidationHistory = ref(null);
</script>

<template>
    <DashboardLayout title="Validation de recharge">
        <template #header>
            <DashboardBreadcrumb title="Validation de recharge">
                <BreadcrumbItem :url="route('dashboard.card_holders.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Porteurs de carte
                </BreadcrumbItem>
                <BreadcrumbItem>Validation de recharge</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="sm:flex w-full items-center">
                <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <SearchField v-model="search" placeholder="Rechercher" />
                </div>
            </div>    
        </div>

        <Table>
            <Thead v-if="props.cardHolder.data.endowments.length">
                <Tr>
                    <Th>Montant</Th>
                    <Th>Type de dotation</Th>
                    <Th>Statut actuel</Th>
                    <Th>Actions</Th>
                </Tr>
            </Thead>
            <Tbody>
                <NoRecords v-if="props.cardHolder.data.endowments.length == 0" title="Aucune recharge effectuée pour le moment..."/>

                <Tr v-for="endowment in props.cardHolder.data.endowments" :key="`endowment-${endowment.id}`">
                    <Td><NumberFormatter :value="endowment.computed_value" currency="XOF" /></Td>
                    <Td>{{ endowment.dotation_name }}</Td>
                    <Td>
                        <StatusBadge :name="endowment.endowment_status.name">{{ endowment.endowment_status.description || '---' }}</StatusBadge>
                    </Td>
                    <Td>
                        <ButtonGroup>
                            <PrimaryButton 
                                v-if="endowment.endowment_status.can_be_validated" 
                                @click.prevent="showValidationForm = endowment.id">
                                Valider
                            </PrimaryButton>
                            <SecondaryButton @click.prevent="showValidationHistory = endowment.id">Historique de validation</SecondaryButton>
                        </ButtonGroup>

                        <EndowmentValidationForm :endowment="endowment" :show="showValidationForm === endowment.id" @close="showValidationForm = null" />
                        <EndowmentValidationHistory :endowment="endowment" :show="showValidationHistory === endowment.id" @close="showValidationHistory = null"/>
                    </Td>
                </Tr>
            </Tbody>
        </Table>
    </DashboardLayout>
</template>