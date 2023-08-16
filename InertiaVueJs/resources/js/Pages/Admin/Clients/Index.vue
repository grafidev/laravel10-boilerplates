<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Table from './Table.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { UsersIcon } from '@heroicons/vue/24/outline';
import Create from './Create.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const createClient = ref(false);

const props = defineProps({ 
    clients: Object, 
    perpage: [String, Number], 
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des clients">
        <template #header>
            <DashboardBreadcrumb title="Liste des clients">
                <BreadcrumbItem :url="route('dashboard.clients.index')">
                    <UsersIcon class="w-5 h-5 mr-2.5" /> Clients
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton v-if="auth.permissions.includes('create_client')" @click.prevent="createClient = true">Créer</PrimaryButton>
            <Create :show="createClient" @close="createClient = false" />
        </template>

        <Table :perpage="props.perpage" :clients="props.clients" :filters="props.filters" />
    </DashboardLayout>    
</template>