<script setup>
import { useForm } from '@inertiajs/vue3';
import FormCard from '@/Components/FormCard.vue';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import { onMounted } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import { UserIcon } from '@heroicons/vue/24/outline';

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
    products: [],
    active: true,
});

const submit = () => {
    form.post(route('dashboard.users.store'), {
        onSuccess: () => {
            form.reset();
            close();
            Alert.success('Le compte a bien été créé.');
        }
    });
};

const close = () => emit('close');

onMounted(() => {
    form.role_id = props.roles.find(role => role.name == 'ADMIN')?.id;
});
</script>

<template>
    <DashboardLayout title="Ajouter un compte utilisateur">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un compte utilisateur">
                <BreadcrumbItem :url="route('dashboard.super_admins.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Comptes super admins
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un compte utilisateur</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Ajouter un compte utilisateur">
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