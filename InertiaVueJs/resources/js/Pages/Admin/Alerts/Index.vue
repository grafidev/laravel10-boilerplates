<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { BellIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const showCreate = ref(false);

const props = defineProps({ 
    alerts: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des alertes">
        <template #header>
            <DashboardBreadcrumb title="Liste des alertes">
                <BreadcrumbItem :url="route('dashboard.alerts.index')">
                    <BellIcon class="w-5 h-5 mr-2.5" /> Alertes
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
            <Create :show="showCreate" @close="showCreate = false" />
        </template>
        
        <Table :filters="props.filters" :perpage="perpage" :alerts="props.alerts" />
    </DashboardLayout>    
</template>