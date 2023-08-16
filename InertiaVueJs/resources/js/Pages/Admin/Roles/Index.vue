<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Table from './Table.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { UserGroupIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({ 
    roles: Object, 
    permissions: Array, 
    perpage: [String, Number],
    filters: Object,
});

const { auth } = usePage().props;

</script>

<template>
    <DashboardLayout title="Liste des rôles">
        <template #header>
            <DashboardBreadcrumb title="Liste des roles">
                <BreadcrumbItem :url="route('dashboard.roles.index')">
                    <UserGroupIcon class="w-5 h-5 mr-2.5" /> Roles
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="router.visit(route('dashboard.roles.create'))" v-if="auth.permissions.includes('create_role')">
                Créer
            </PrimaryButton>
        </template>

        <Table :filters="filters" :perpage="perpage" :roles="roles" :permissions="permissions" />
    </DashboardLayout>    
</template>