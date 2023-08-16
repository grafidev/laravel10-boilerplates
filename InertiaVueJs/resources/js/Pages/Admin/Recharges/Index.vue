<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Table from './Table.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Create from './Create.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';

const { auth } = usePage().props;

const props = defineProps({ 
    recharges: Object, 
    perpage: [String, Number],
    filters: Object,
    users: Array,
});

const showCreate = ref(false);
</script>

<template>
    <DashboardLayout title="Recharges">
        <template #header>
            <DashboardBreadcrumb title="Recharges">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.recharges.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <ArrowDownTrayIcon class="w-5 h-5 mr-2.5" />
                        Recharges
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
            <PrimaryButton v-if="auth.permissions.includes('create_recharge')" type="button" @click="showCreate = true">
                Créer
            </PrimaryButton>
        </template>

        <Create :show="showCreate" @close="showCreate = false" :users="props.users" />

        <Table :filters="filters" :perpage="perpage" :recharges="recharges" :users="props.users"  />
    </DashboardLayout>    
</template>