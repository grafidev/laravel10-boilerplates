<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    corporateClients: Array,
    clients: Array,
});

const form = useForm({
    corporate_client_id: '',
    client_id: '',
    profile_type: 'professionnel',
    expiration_date: '',
});

const submit = () => {
    form.post(route('dashboard.purchase_orders.store'), {
        onSuccess: () => {
            Alert.success('Le bon de carburant a bien été créé.');
        }
    });
};
const cancel = () => router.visit(route('dashboard.purchase_orders.index'));
</script>

<template>
    <DashboardLayout title="Ajouter un bon de carburant">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un bon de carburant">
                <BreadcrumbItem :url="route('dashboard.purchase_orders.index')">
                    Bons de carburant
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un bon de carburant</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard>
            <form class="flex flex-col gap-y-6" @submit.prevent="submit"> 
                <Fields :form="form" :corporate_clients="props.corporateClients" :clients="props.clients"/>

                <div class="col-span-full flex items-center justify-end gap-2">
                    <SecondaryButton type="button" @click="cancel">Annuler</SecondaryButton>
                    <PrimaryButton type="submit">Enregistrer</PrimaryButton>
                </div>
            </form>
        </FormCard>
    </DashboardLayout>
</template>
