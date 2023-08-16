<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';

import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { BugAntIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const showCreate = ref(false);

const props = defineProps({ 
    anomalies: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des anomalies">
        <template #header>
            <DashboardBreadcrumb title="Liste des anomalies">
                <BreadcrumbItem :url="route('dashboard.anomalies.index')">
                    <BugAntIcon class="w-5 h-5 mr-2.5" /> Anomalies
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
        </template>

        <Create :show="showCreate" @close="showCreate = false" />
        
        <Table :filters="props.filters" :perpage="perpage" :anomalies="props.anomalies" />
    </DashboardLayout>    
</template>