<script setup>
import ButtonGroup from '@/Components/ButtonGroup.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import NoRecords from '@/Components/NoRecords.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import Table from '@/Components/Table/Table.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Td from '@/Components/Table/Td.vue';
import Th from '@/Components/Table/Th.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tr from '@/Components/Table/Tr.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    corporateClient: Object,
    cardHolder: Object,
});

const close = () => emit('close');
</script>

<template>
    <Modal :show="show" @close="close" max-width="4xl">
        <div class="p-6">
            <h2 class="text-lg font-extrabold text-gray-900 dark:text-white mb-7">
                Liste des dotations pour le porteur {{ props.cardHolder.name }} 
            </h2>


            <Table>
                <Thead v-if="props.cardHolder.endowments.length">
                    <Tr>
                        <Th>Montant</Th>
                        <Th>Type de dotation</Th>
                        <Th>Statut</Th>
                        <Th>Actions</Th>
                    </Tr>
                </Thead>
                <Tbody>
                    <NoRecords v-if="props.cardHolder.endowments.length == 0" title="Aucune recharge effectuée pour le moment..." colspan="4"/>

                    <Tr v-for="endowment in props.cardHolder.endowments" :key="`endowment-${endowment.id}`">
                        <Td>{{ endowment.computed_value }}</Td>
                        <Td>{{ endowment.dotation_name }}</Td>
                        <Td>
                            <StatusBadge :name="endowment.endowment_status.name">{{ endowment.endowment_status.description }}</StatusBadge>
                        </Td>
                        <Td>
                            <ButtonGroup>
                                <PrimaryButton>Valider</PrimaryButton>
                                <DangerButton>Rejeter</DangerButton>
                            </ButtonGroup>
                        </Td>
                    </Tr>
                </Tbody>
            </Table>
        </div>
    </Modal>
</template>