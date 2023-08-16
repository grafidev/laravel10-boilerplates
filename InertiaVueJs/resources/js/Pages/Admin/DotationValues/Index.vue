<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';

import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { BugAntIcon } from '@heroicons/vue/24/outline';

const { auth } = usePage().props;

const showCreate = ref(false);

const props = defineProps({ 
    dotationValues: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Valeurs de dotation">
        <template #header>
            <DashboardBreadcrumb title="Liste des valeurs de dotation">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.dotationValues.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5 fill-current mr-2.5">
                            <path d="M222-80q-43.75 0-74.375-30.625T117-185v-125h127v-570l59.8 60 59.8-60 59.8 60 59.8-60 59.8 60 60-60 60 60 60-60 60 60 60-60v695q0 43.75-30.625 74.375T738-80H222Zm516-60q20 0 32.5-12.5T783-185v-595H304v470h389v125q0 20 12.5 32.5T738-140ZM357-622v-60h240v60H357Zm0 134v-60h240v60H357Zm333-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221-140h412v-110H177v65q0 20 12.65 32.5T221-140Zm-44 0v-110 110Z"/>
                        </svg>
                        Valeurs de dotation
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Liste</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
        </template>

        <Create :show="showCreate" @close="showCreate = false" />
        
        <Table :filters="props.filters" :perpage="perpage" :dotation-values="props.dotationValues" />
    </DashboardLayout>    
</template>