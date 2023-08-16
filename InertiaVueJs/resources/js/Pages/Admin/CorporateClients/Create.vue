<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const form = useForm({
    name: '',
    ninea: '',
    address: '',
    email: '',
    phone_number: '',
    contact_name: '',
    contact_email: '',
    contact_phone_number: '',
    commercial_register_number: '',
    commercial_register_file: null,
    exoneration_title: null,
    regime: null,
    discount: 0,
    currency: 'XOF',
    periodicity: 30,
});

const submit = () => {
    form.post(route('dashboard.corporate_clients.store'), {
        onSuccess: () => {
            Alert.success('Le client (entreprise) a bien été enregistré.');
        }
    });
};
</script>

<template>
    <DashboardLayout title="Ajouter un client (entreprise)">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un client (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un client (entreprise)</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard>
            <form class="flex flex-col gap-y-6" @submit.prevent="submit"> 
                <Fields :form="form" />
            </form>
        </FormCard>
    </DashboardLayout>
</template>