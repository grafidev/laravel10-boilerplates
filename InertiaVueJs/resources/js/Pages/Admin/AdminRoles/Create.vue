<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { useForm } from '@inertiajs/vue3';
import Fields from './Fields.vue';
import { Alert } from '@/alert';
import { UserGroupIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    permissions: Array,
    roles: Array,
    show: { type: Boolean, default: false },
});

const form = useForm({ 
    name: '', 
    description: '', 
    permissions: [],
});

const submit = () => form.post(route('dashboard.admin_roles.store'), {
    onSuccess: () => {
        Alert.success('Le rôle a bien été ajouté.');
    }
});
</script>

<template>
    <DashboardLayout title="Ajouter un rôle">
        <template #header>
            <DashboardBreadcrumb title="Ajouter un rôle">
                <BreadcrumbItem :url="route('dashboard.admin_roles.index')">
                    <UserGroupIcon class="w-5 h-5 mr-2.5" /> Roles & permissions
                </BreadcrumbItem>
                <BreadcrumbItem>Ajouter un rôle</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard>
            <form @submit.prevent="submit"> 
                <Fields :form="form" :permissions="props.permissions" :roles="props.roles" />
            </form>
        </FormCard>
    </DashboardLayout>
</template>