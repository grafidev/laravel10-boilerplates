<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Table from './Table.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { UserIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({ 
    users: Object, 
    roles: Array, 
    countries: Array,
    companies: Array,
    perpage: [String, Number],
    filters: Object,
});

const { auth } = usePage().props;
</script>

<template>
    <DashboardLayout title="Comptes utilisateurs">
        <template #header>
            <DashboardBreadcrumb title="Comptes utilisateurs">
                <BreadcrumbItem :url="route('dashboard.users.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Comptes utilisateurs
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton v-if="auth.permissions.includes('create_user')" @click.prevent="router.visit(route('dashboard.users.create'))" type="button">
                Créer
            </PrimaryButton>
        </template>

        <Table 
            :countries="props.countries" 
            :companies="props.companies" 
            :roles="props.roles" 
            :users="props.users" 
            :perpage="props.perpage" 
            :filters="props.filters" 
        />
    </DashboardLayout>    
</template>