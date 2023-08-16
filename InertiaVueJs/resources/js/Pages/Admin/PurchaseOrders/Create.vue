<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';

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
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.purchase_orders.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        Bons de carburant
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Ajouter un bon de carburant</span>
                    </div>
                </li>
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
