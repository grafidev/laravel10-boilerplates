<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import Fields from './Fields.vue';
import { UserGroupIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const props = defineProps({
    permissions: Array,
    role: Object,
});

const form = useForm({ 
    name: props.role.name, 
    description: props.role.description, 
    permissions: props.role.permissions.map(p => p.id),
});

const submit = () => {
    form.put(route('dashboard.roles.update', { role: props.role.id }), {
        onSuccess: () => {
            Alert.success('Le rôle a bien été modifié.');
        }
    });
};
</script>

<template>
    <DashboardLayout title="Modifier un rôle">
        <template #header>
            <DashboardBreadcrumb title="Modifier un rôle">
                <BreadcrumbItem :url="route('dashboard.roles.index')">
                    <UserGroupIcon class="w-5 h-5 mr-2.5"/> Roles
                </BreadcrumbItem>
                <BreadcrumbItem>Modifier un rôle</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <FormCard>
            <form @submit.prevent="submit"> 
                <Fields :form="form" :permissions="props.permissions" :role="props.role" />
            </form>
        </FormCard>
    </DashboardLayout>
</template>