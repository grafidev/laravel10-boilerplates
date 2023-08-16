<script setup>
import { useForm } from '@inertiajs/vue3';
import Fields from './Fields.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { UserIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const emit = defineEmits(['close']);
const props = defineProps({ roles: Array, user: Object });

const form = useForm({
    firstname: props.user.data.firstname,
    lastname: props.user.data.lastname,
    email: props.user.data.email,
    phone_number: props.user.data.phone_number,
    address: props.user.data.address,
    role_id: props.user.data.role_id,
    active: props.user.data.active,
});

const submit = () => form.put(route('dashboard.users.update', { user: props.user.data.id }));
</script>

<template>
    <DashboardLayout title="Modifier un compte utilisateur">
        <template #header>
            <DashboardBreadcrumb title="Modifier un compte utilisateur">
                <BreadcrumbItem :url="route('dashboard.users.index')">
                    <UserIcon class="w-5 h-5 mr-2.5" /> Comptes utilisateurs
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.user.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Modifier</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard title="Modifier le compte utilisateur">
            <form @submit.prevent="submit">
                <Fields 
                    :form="form" 
                    :roles="props.roles" 
                    :user="props.user.data"
                />
            </form>
        </FormCard>
    </DashboardLayout>
</template>