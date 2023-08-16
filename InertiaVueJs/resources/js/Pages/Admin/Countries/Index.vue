<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Th from '@/Components/Table/Th.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import NoRecords from '@/Components/NoRecords.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Create from './Create.vue';
import Edit from './Edit.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref, watch } from 'vue';
import { Link, router, usePage } from "@inertiajs/vue3";
import SortableLink from '@/Components/Table/SortableLink.vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import { FlagIcon } from '@heroicons/vue/24/outline';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import FormCard from '@/Components/FormCard.vue';

const editingCountry = ref(null);
const showCreate = ref(false);
const props = defineProps({
  countries: Object, 
  perpage: [String, Number],
  countriesList: Array,
  filters: Object,
});

const search = ref(props.filters.search);

const { auth } = usePage().props;

const onChangePerPage = (perpage) => {
    changePerPage(perpage);
};

watch(search, value => {
    router.get(route('dashboard.countries.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const deleteCountry = (country) => {
    Alert.confirm('Êtes vous sûr de supprimer ceci ?').then(result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.countries.destroy', { country: country.id }), {
                onSuccess: () => Alert.success('Suppression effectuée avec succès.'),
            });
        }
    });
};

const onChangeState = (event, country) => {
    router.put(route('dashboard.countries.toggleActivation', { country: country.id }), {
        active: event.target.checked,
    });
};
</script>

<template>
  <DashboardLayout title="Gestion des pays">
    <template #header>
        <DashboardBreadcrumb title="Gestion des pays">
            <BreadcrumbItem :url="route('dashboard.countries.index')">
                <FlagIcon class="w-5 h-5 mr-2.5" /> Pays
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <template #actions>
    </template>

    <SettingsPartials>
        <SearchWrapper>
            <template #end>
                <SearchField v-model="search" placeholder="Rechercher un pays" />
            </template>
        </SearchWrapper>
        <FormCard title="Gestion des pays" :shadow="false">
            <template #actions>
                <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
                <Create :show="showCreate" @close="showCreate = false" :countries-list="countriesList"/>
            </template>

            <Table>
                <Thead v-if="props.countries.data.length">
                    <Tr>
                        <Th><SortableLink label="Nom" attribute="name" /></Th>
                        <Th><SortableLink label="Identificatif téléphonique" attribute="dialing_code" /></Th>
                        <Th>Actions</th>
                    </Tr>
                </Thead>
        
                <Tbody>
                    <NoRecords colspan="3" v-if="props.countries.data.length == 0" title="Aucun pays enregistré"/>
                    <Tr v-for="country in props.countries.data" :key="country.id">
                        <Td>{{ country.name }}</Td>
                        <Td>{{ country.dialing_code }}</Td>
                        <Td>
                            <div class="flex items-center gap-2">
                                <PrimaryButton v-if="auth.permissions.includes('edit_country')" type="button" @click="editingCountry = country.id">
                                    Modifier
                                </PrimaryButton>
                                <DangerButton v-if="auth.permissions.includes('delete_country')" @click.prevent="deleteCountry(country)">Supprimer</DangerButton>
                            </div>
                            <Edit :countries-list="countriesList" :show="editingCountry == country.id" @close="editingCountry = null" :country="country" />
                        </Td>
                    </Tr>
                </Tbody>
            </Table>
        </FormCard>
        <Pagination :meta="props.countries.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.countries.meta.links" />
    </SettingsPartials>

  </DashboardLayout>
</template>


<style>
@import 'vue-select/dist/vue-select.css';

.fw-btn {
    background: #dc2626;
    font-family: Ubuntu;
}

.dark .fw-card {
    @apply bg-gray-800 border-gray-700;
}

.dark .fw-step-title {
    @apply text-white;
}

.dark .fw-body-container {
    @apply !border-red-100;
}

:root {
    --vs-dropdown-option--active-bg: #dc2626;
}

.form-wizard-vue .fw-body-list .fw-list-progress-active {
    background: linear-gradient(90deg,#000 -3.12%,#dc2626 48.22%,#fff 105.52%);
}

.form-wizard-vue .fw-step-checked {
    border-color: #dc2626;
}

.form-wizard-vue .fw-step-active {
    background: linear-gradient(90deg,#dc2626 0%,#dc2626 100%)!important;
    color: #fff!important;
}

.form-wizard-vue .fw-footer {
    padding: 10px 58px;
}

.dark .vs--searchable .vs__dropdown-toggle {
    @apply border border-gray-600 bg-gray-700;
}

.dark .vs--disabled .vs__dropdown-toggle, 
.dark .vs--disabled .vs__clear, 
.dark .vs--disabled .vs__search, 
.dark .vs--disabled .vs__selected, 
.dark .vs--disabled .vs__open-indicator {
    @apply bg-gray-700;
}

.dark .vs__selected-options {
    @apply text-white;
}

.dark .vs__dropdown-menu {
    @apply bg-gray-800 border border-gray-700;
}

.dark .vs__selected {
    @apply text-white;
}

.dark .vs__dropdown-option {
    @apply bg-gray-800 hover:bg-gray-700;
}

.dark .form-wizard-vue .fw-body-list li .fw-list-wrapper-icon {
    @apply bg-gray-700 text-white;
}
</style>