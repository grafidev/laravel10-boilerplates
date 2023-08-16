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
    products: Array, 
    countries: Array,
    companies: Array,
    perpage: { type: [String, Number] },
    filters: Object,
});

const { auth } = usePage().props;
</script>

<template>
    <DashboardLayout title="Clients">
        <template #header>
            <DashboardBreadcrumb title="Clients">
                <BreadcrumbItem :url="route('dashboard.customers.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Clients CARDOIL
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton v-if="auth.permissions.includes('create_user')" @click.prevent="router.visit(route('dashboard.customers.create'))" type="button">
                Créer
            </PrimaryButton>
        </template>

        <Table 
            :countries="props.countries" 
            :products="props.products" 
            :companies="props.companies" 
            :roles="props.roles" 
            :users="props.users" 
            :perpage="props.perpage" 
            :filters="props.filters"
        />
    </DashboardLayout>    
</template>