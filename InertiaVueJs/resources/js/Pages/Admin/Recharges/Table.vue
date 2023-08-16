<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Edit from './Edit.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { changePerPage } from '@/utils';
import SortableLink from '@/Components/Table/SortableLink.vue';
import NoRecords from '@/Components/NoRecords.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import Badge from '@/Components/Badge.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import { Alert } from '@/alert';

const props = defineProps({ 
    recharges: Object, 
    perpage: [String, Number],
    filters: Object,
    users: Array,
});

const search = ref(props.filters.search);
const editingRecharge = ref(null);
const { auth } = usePage().props;

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.recharges.index'));
};

const deleteRecharge = (id) => {
    Alert.confirm('Êtes vous sûr.e?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.recharges.destroy', { recharge: id }), {
                onSuccess: () => {
                    Alert.success('Suppression effectuée avec succès.');
                }
            });
        }
    });
};

watch(search, (value) => {
    router.get(route('dashboard.recharges.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:flex w-full items-center">
            <div class="items-center w-full justify-end hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <SearchField v-model="search" placeholder="Rechercher" />
            </div>
        </div>    
    </div>

    <Table>
        <Thead v-if="props.recharges.data.length">
            <Tr>
                <Th><SortableLink label="Montant" attribute="amount" /></Th>
                <Th><SortableLink label="Utilisateur" attribute="user.name" /></Th>
                <Th><SortableLink label="Role" attribute="roles_name" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th><SortableLink label="Statut" attribute="rechargeStatus.name" /></Th>
                <Th><SortableLink label="Type de recharge" attribute="is_internal" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords title="Aucune recharge n'a été effectuée" v-if="props.recharges.data.length == 0" />

            <Tr v-for="recharge in props.recharges.data" :key="recharge.id">
                <Td><NumberFormatter :value="recharge.amount" currency="XOF" /></Td>
                <Td>{{ recharge.user.name }}</Td>
                <Td>{{ recharge.user.roles_list }}</Td>
                <Td><DateForHumans :date="recharge.created_at" /></Td>
                <Td>
                    <Badge color="info" v-if="recharge.rechargeStatus?.name">{{ recharge.rechargeStatus?.name }}</Badge>
                    <span v-else>---</span>
                </Td>
                <Td>{{ recharge.type }}</Td>
                <Td>
                    <ButtonGroup>
                        <PrimaryButton @click.prevent="router.visit(route('dashboard.recharges.show', { recharge: recharge.id }))">
                            Valider
                        </PrimaryButton>
                        <DangerButton @click.prevent="deleteRecharge(recharge.id)">Supprimer</DangerButton>
                    </ButtonGroup>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="recharges.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="recharges.meta.links" />
</template>