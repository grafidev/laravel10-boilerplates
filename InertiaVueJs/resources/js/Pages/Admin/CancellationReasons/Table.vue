<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import Th from '@/Components/Table/Th.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import Edit from './Edit.vue';
import Create from './Create.vue';
import { ref, watch } from 'vue';
import NoRecords from '@/Components/NoRecords.vue';
import { router } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import SearchField from '@/Components/Forms/SearchField.vue';

const props = defineProps({
    cancellation_reasons: Object,
    perpage: [String, Number],
    filters: Object,
});

const editingReason = ref(null);
const createReason = ref(false);
const search = ref(props.filters.search);

const deleteCancellationReason = (reason) => Alert.confirm('Êtes vous sûr.e?', result => {
    if(result.isConfirmed) {
        router.delete(route('dashboard.companies.cancellation_reasons.destroy', { cancellation_reason: reason.id }));
    }
});

watch(search, value => {
    router.get(route('dashboard.companies.cancellation_reasons.index'), { search: value }, {
        preserveState: true,
        preserveScroll: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une raison" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.cancellation_reasons.data.length">
            <Tr>
                <Th><SortableLink label="Libellé" attribute="name" /></Th>
                <Th>Actions</Th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords v-if="props.cancellation_reasons.data.length == 0" />
            
            <Tr v-for="reason in props.cancellation_reasons.data" :key="reason.id">
                <Td>{{ reason.name }}</Td>
                <Td>
                    <ButtonGroup>
                        <PrimaryButton @click.prevent="editingReason = reason.id">Modifier</PrimaryButton>
                        <DangerButton @click.prevent="deleteCancellationReason(reason)">Supprimer</DangerButton>
                    </ButtonGroup>
                    <Edit :show="editingReason == reason.id" @close="editingReason = null" :cancellation_reason="reason" />
                </Td>
            </Tr>
        </Tbody>
    </Table>
</template>