<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { useForm, router } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    corporateClient: Object,
});

const form = useForm({
    name: props.corporateClient.name,
    ninea: props.corporateClient.ninea,
    address: props.corporateClient.address,
    email: props.corporateClient.email,
    phone_number: props.corporateClient.phone_number,
    contact_name: props.corporateClient.contact_name,
    contact_email: props.corporateClient.contact_email,
    contact_phone_number: props.corporateClient.contact_phone_number,
    commercial_register_number: props.corporateClient.commercial_register_number,
    regime: props.corporateClient.regime,
    discount: props.corporateClient.discount,
    currency: props.corporateClient.currency,
    periodicity: props.corporateClient.periodicity,
});

const submit = () => {
    form.put(route('dashboard.corporate_clients.update', { corporate_client: props.corporateClient.id }), {
        onSuccess: () => {
            router.visit(route('dashboard.corporate_clients.index'));
            Alert.success('Le client (entreprise) a bien été modifié.');
        }
    });
};
</script>

<template>
    <DashboardLayout title="Modifier un client (entreprise)">
        <template #header>
            <DashboardBreadcrumb title="Modifier un client (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>Modifier un client (entreprise)</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard>
            <form class="flex flex-col gap-y-6" @submit.prevent="submit"> 
                <Fields :form="form" />
            </form>
        </FormCard>
    </DashboardLayout>
</template>