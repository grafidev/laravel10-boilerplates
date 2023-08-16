<script setup>
import { useForm } from '@inertiajs/vue3';
import FormCard from '@/Components/FormCard.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import { onMounted } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import { UserIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    roles: Array,
    countries: Array,
    companies: Array,
    products: Array,
    show: { type: Boolean, default: false },
});

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    phone_number: '',
    address: '',
    role_id: '',
    country_id: '',
    currency: 'XOF',
    companies: [],
    company_id: '',
    products: [],
    active: true,
});

const submit = () => {
    form.post(route('dashboard.customers.store'), {
        onSuccess: () => {
            Alert.success("Un lien de création d'un nouveau mot de passe a bien envoyé à l'adresse: <span class='font-bold text-green-500'>" + form.email + '</span>');
            form.reset();
            close();
        }
    });
};

const close = () => emit('close');

onMounted(() => {
    form.role_id = props.roles.find(role => role.name == 'ADMIN')?.id;
});
</script>

<template>
    <DashboardLayout title="Ajouter un client">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un client">
                <BreadcrumbItem :url="route('dashboard.customers.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Clients CARDOIL
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un client</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Ajouter un client">
            <form @submit.prevent="submit">
                <Fields 
                    is-admin
                    :countries="props.countries" 
                    :companies="props.companies" 
                    :products="props.products" 
                    :form="form" 
                    :roles="props.roles" 
                />
            </form>
        </FormCard>
    </DashboardLayout>
</template>