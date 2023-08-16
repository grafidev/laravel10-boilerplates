<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link } from '@inertiajs/vue3';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import { UserIcon } from '@heroicons/vue/24/outline';
const emit = defineEmits(['close']);

const props = defineProps({
    roles: Array,
    role: Object,
    countries: Array,
    companies: Array,
    products: Array,
    show: { type: Boolean, default: false },
    user: Object,
    id: String,
});

const form = useForm({
    firstname: props.user.data.firstname,
    lastname: props.user.data.lastname,
    email: props.user.data.email,
    phone_number: props.user.data.phone_number,
    address: props.user.data.address,
    role_id: props.user.data.role_id,
    active: props.user.data.active,
    country_id: props.user.data.country_id,
    currency: props.user.data.currency,
    companies: props.user.data.companies.map(c => c.id),
    products: props.user.data.products.map(p => p.id),
});

const submit = () => {
    form.put(route('dashboard.super_admins.update', { super_admin: props.user.data.id }), {
        onSuccess: () => {
            close();
            Alert.success('Le compte a bien été modifié.');
        }
    });
};

const close = () => emit('close');
</script>

<template>
    <DashboardLayout title="Modifier un compte utilisateur">
        <template #header>
            <DashboardBreadcrumb title="Modifier un compte utilisateur">
                <BreadcrumbItem :url="route('dashboard.super_admins.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Comptes super admins
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.user.data.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Modifier le compte utilisateur">
            <form @submit.prevent="submit">
                <Fields 
                    :form="form" 
                    :user="props.user.data"
                />
            </form>
        </FormCard>
    </DashboardLayout>
</template>