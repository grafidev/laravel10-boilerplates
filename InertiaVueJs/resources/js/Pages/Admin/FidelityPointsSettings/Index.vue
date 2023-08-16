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
import { ref } from 'vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Th from '@/Components/Table/Th.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue'

const props = defineProps({
    companies: Array,
    settings: Object,
    fidelity_points_settings: Object,
});

const addConfig = ref(false);
const editConfig = ref(null);
const deletePoint = pointId => {
    Alert.confirm('Êtes vous sûr.e?', result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.companies.fidelity_points_settings.destroy', { fidelity_point_settings: pointId }), {
                onSuccess: () => {
                    Alert.success('Configuration supprimée avec succès.');
                },
            });
        }
    })
};

</script>

<template>
    <DashboardLayout title="Configuration">
        <template #header>
            <DashboardBreadcrumb title="Configuration des points de fidélité">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.companies.fidelity_points_settings.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        Configuration des points de fidélité
                    </Link>
                </li>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <FormCard title="Configuration de points de fidélité">
                <template #actions>
                    <PrimaryButton @click.prevent="addConfig = true">Ajouter</PrimaryButton>
                </template>
                
                <Create :show="addConfig" @close="addConfig = false" />

                <Table>
                    <Thead v-if="props.fidelity_points_settings.data.length">
                        <Tr>
                            <Th><SortableLink label='Montant minimal' attribute='minimal_amount'/></Th>
                            <Th><SortableLink label='Points gagnés' attribute='earned_points'/></Th>
                            <Th>Actions</Th>
                        </Tr>
                    </Thead>

                    <Tbody>
                        <NoRecords title="Aucun point de fidélité configuré pour le moment..." v-if="props.fidelity_points_settings.data.length == 0"/>
                        <Tr v-for="point in props.fidelity_points_settings.data" :key="point.id">
                            <Td>{{ point.minimal_amount }}</Td>
                            <Td>{{ point.earned_points }}</Td>
                            <Td>
                                <ButtonGroup>
                                    <PrimaryButton @click.prevent="editConfig = point.id">Modifier</PrimaryButton>
                                    <DangerButton @click.prevent="deletePoint(point.id)">Supprimer</DangerButton>
                                </ButtonGroup>
                                <Edit :point="point" :show="editConfig == point.id" @close="editConfig = null" />
                            </Td>
                        </Tr>
                    </Tbody>
                </Table>
            </FormCard>
        </CustomerSettingsTabs>
    </DashboardLayout>
</template>