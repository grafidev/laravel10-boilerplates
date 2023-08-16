<script setup>
import { useForm } from '@inertiajs/vue3';
import FormCard from '@/Components/FormCard.vue';
import Fields from './Fields.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { UserIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    roles: Array,
});

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    phone_number: '',
    address: '',
    role_id: null,
    active: true,
});

const submit = () => form.post(route('dashboard.users.store'));
</script>

<template>
    <DashboardLayout title="Ajouter un compte utilisateur">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un compte utilisateur">
                <BreadcrumbItem :url="route('dashboard.users.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Comptes utilisateurs
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un compte utilisateur</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Ajouter un compte utilisateur">
            <form @submit.prevent="submit">
                <Fields 
                    :form="form" 
                    :roles="props.roles" 
                />
            </form>
        </FormCard>
    </DashboardLayout>
</template>