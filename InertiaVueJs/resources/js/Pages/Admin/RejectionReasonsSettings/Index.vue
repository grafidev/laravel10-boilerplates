<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Alert } from '@/alert';
import CustomerSettingsTabs from '@/Components/CustomerSettingsTabs.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import { ref, watch } from 'vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Th from '@/Components/Table/Th.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    filters: Object,
    rejectionReasons: Object,
    perpage: [String, Number],
});

const createRejectionReason = ref(false);
const editingRejectionReason = ref(null);
const search = ref('');

const deleteRejectionReason = reasonId => {
    Alert.confirm('Êtes vous sûr.e?', result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.companies.rejection_reasons.destroy', { rejection_reason: reasonId }), {
                onSuccess: () => {
                    Alert.success('Configuration supprimée avec succès.');
                },
            });
        }
    })
};

watch(search, value => {
    router.get(route('dashboard.companies.rejection_reasons.index'), { ...props.filters, search: value }, {
        preserveScroll: true,
        preserveState: true,
    }); 
});
</script>

<template>
    <DashboardLayout title="Configuration">
        <template #header>
            <DashboardBreadcrumb title="Configuration des points de fidélité">
                <BreadcrumbItem :url="route('dashboard.companies.rejection_reasons.index')">Motifs de rejet</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <FormCard title="Motifs de rejet" :shadow="false">
                <template #actions>
                    <PrimaryButton @click.prevent="createRejectionReason = true">Ajouter</PrimaryButton>
                </template>
                
                <SearchWrapper>
                    <template #end>
                        <SearchField v-model="search" placeholder="Rechercher" />
                    </template>
                </SearchWrapper>

                <Create :show="createRejectionReason" @close="createRejectionReason = false" />

                <Table>
                    <Thead v-if="props.rejectionReasons.data.length">
                        <Tr>
                            <Th><SortableLink label="Nom" attribute="name" /></Th>
                            <Th><SortableLink label="Etat" attribute="active" /></Th>
                            <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                            <Th>Actions</th>
                        </Tr>
                    </Thead>

                    <Tbody>
                        <NoRecords v-if="props.rejectionReasons.data.length == 0" title="Aucun motif de rejet enregistré" />

                        <Tr v-for="rejectionReason in props.rejectionReasons.data" :key="rejectionReason.id">
                            <Td>{{ rejectionReason.name }}</Td>
                            <Td><ActiveIcon :active="rejectionReason.active"/></Td>
                            <Td><DateForHumans :date="rejectionReason.created_at" /></Td>
                            <Td>
                                <div class="flex items-center gap-2">
                                    <PrimaryButton @click.prevent="editingRejectionReason = rejectionReason.id">Modifier</PrimaryButton>
                                    <DangerButton @click.prevent="deleteRejectionReason(rejectionReason)">Supprimer</DangerButton>
                                </div>
                                <Edit :show="editingRejectionReason == rejectionReason.id" @close="editingRejectionReason = null" :rejection-reason="rejectionReason"/>
                            </Td>
                        </Tr>
                    </Tbody>
                </Table> 

                <Pagination :meta="props.rejectionReasons.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.rejectionReasons.meta.links" />
            </FormCard>
        </CustomerSettingsTabs>
    </DashboardLayout>
</template>