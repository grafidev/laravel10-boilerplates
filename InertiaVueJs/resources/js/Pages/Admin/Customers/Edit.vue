<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { UserIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
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

const selectedCompanyId = computed(() => {
    return props.user.data.companies?.length > 0 ? props.user.data.companies[0]?.id : null;
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
    company_id: selectedCompanyId.value,
    products: props.user.data.products.map(p => p.id),
});


const submit = () => {
    form.put(route('dashboard.customers.update', { customer: props.user.data.id }), {
        onSuccess: () => {
            close();
            Alert.success('Le compte a bien été modifié.');
        }
    });
};

const close = () => emit('close');
</script>

<template>
    <DashboardLayout title="Modifier un compte client">
        <template #header>
            <DashboardBreadcrumb title="Modifier un compte client">
                <BreadcrumbItem :url="route('dashboard.customers.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Clients CARDOIL
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.user.data.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Modifier le compte client">
            <form @submit.prevent="submit">
                <Fields 
                    :products="props.products" 
                    :countries="props.countries" 
                    :companies="props.companies" 
                    :form="form" 
                    :roles="props.roles" 
                    :user="props.user.data"
                />
            </form>
        </FormCard>
    </DashboardLayout>
</template>