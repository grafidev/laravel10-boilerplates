<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import ModalContent from '@/Components/ModalContent.vue';
import Modal from '@/Components/Modal.vue';
import DateForHumans from '@/Components/DateForHumans.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    product: Object,
});
const close = () => emit('close');
</script>

<template>
    <Modal max-width="4xl" :show="props.show" @close="close">
        <ModalContent title="Prix configurés" @close="close">
            <Table>
                <Thead v-if="product.prices.length">
                    <Tr>
                        <Th>Prix HTT</Th>
                        <Th>Prix HTVA</Th>
                        <Th>Prix TTC</Th>
                        <Th>Début</Th>
                        <Th>Fin</Th>
                    </Tr>
                </Thead>
                <Tbody>
                    <NoRecords v-if="product.prices.length == 0" title="Aucun prix configuré" />
                    <Tr v-for="price in product.prices" :key="`price-${price.id}`">
                        <Td><NumberFormatter :value="price.htt" currency="XOF" /></Td>
                        <Td><NumberFormatter :value="price.htva" currency="XOF" /></Td>
                        <Td><NumberFormatter :value="price.ttc" currency="XOF" /></Td>
                        <Td><DateForHumans :time="false" :date="price.starts_at"/></Td>
                        <Td><DateForHumans :time="false" :date="price.ends_at"/></Td>
                    </Tr>
                </Tbody>
            </Table>
        </ModalContent>
    </Modal>
</template>