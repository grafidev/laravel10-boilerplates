<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed, ref } from 'vue';
import Card from '@/Components/Card.vue';
import NoResults from '@/Components/NoResults.vue';
import CountryImage from '@/Components/CountryImage.vue';

const props = defineProps({
    companies: Array,
    country: Object,
});

const search = ref('');

const filteredCompanies = computed(() => {
    if(search.value) {
        return props.companies.filter(company => {
            return company.name.toLowerCase().includes(search.value.toLowerCase()); 
        });
    }
    return props.companies;
});
</script>

<template>
    <DashboardLayout title="Compagnies">
        <template #header>
            <DashboardBreadcrumb :title="'Compagnies: '+ props.country.name">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.stats.countries.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        Pays
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-white" aria-current="page">{{ props.country.name }}</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <CountryImage :country="props.country" class="w-10"/>
        </template>

        <div class="space-y-4 mt-4">
            <div class="space-y-4 mt-4 w-full" v-if="filteredCompanies.length">
                <div class="grid grid-cols-3">
                    <SearchField v-model="search" placeholder="Rechercher une compagnie" autofocus/>
                </div>
                
                <div class="grid grid-cols-5 gap-4">
                    <Card :href="route('dashboard.stats.companies.stations.index', { country: props.country.id, company: company.id })" :key="company.id" v-for="company in filteredCompanies">{{ company.name }}</Card>
                </div>
            </div>
            <NoResults v-else>
                Aucune compagnie enregistrée pour le pays <span class="uppercase text-green-500 font-extrabold">{{ props.country.name }}</span>
            </NoResults>
        </div>
    </DashboardLayout>
</template>
