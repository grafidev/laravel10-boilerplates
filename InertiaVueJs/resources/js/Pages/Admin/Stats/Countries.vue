<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import CountryCard from '@/Components/CountryCard.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3'; 

const props = defineProps({
    countries: Array,
});

const search = ref('');

const filteredCountries = computed(() => {
    if(search.value) {
        return props.countries.filter(country => {
            return country.name.toLowerCase().includes(search.value.toLowerCase()); 
        });
    }
    return props.countries;
});

const onEnter = (value) => {
    if(filteredCountries.value.length > 0 ) {
        const country = filteredCountries.value[0];
        router.visit(
            route('dashboard.stats.countries.companies.index', { country: country.id })
        );
    }
};
</script>

<template>
    <DashboardLayout title="Pays">
        <template #header>
            <DashboardBreadcrumb title="Pays">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2.5">
                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                        </svg>
                        Accueil
                    </Link>
                </li>
            </DashboardBreadcrumb>
        </template>

        <div class="space-y-4 mt-4">
            <div class="grid grid-cols-3">
                <SearchField v-model="search" placeholder="Rechercher un pays" autofocus @on-enter="onEnter"/>
            </div>

            <div class="grid grid-cols-5 gap-4">
                <CountryCard :href="route('dashboard.stats.countries.companies.index', { country: country.id })" v-for="country in filteredCountries" :key="country.id" :country="country" />
            </div>
        </div>
    </DashboardLayout>
</template>
