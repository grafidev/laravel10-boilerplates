<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import { HomeIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <DashboardLayout title="Mon profil">
        <template #header>
            <DashboardBreadcrumb title="Mon profil">
                <BreadcrumbItem :url="route('dashboard')">
                    <HomeIcon class="w-5 h-5 mr-2.5"/> Accueil
                </BreadcrumbItem>
                <BreadcrumbItem>Mon profil</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <div class="grid grid-cols-2 gap-2">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-2">
                <UpdateProfileInformationForm
                    :must-verify-email="props.mustVerifyEmail"
                    :status="props.status"
                    class="max-w-xl"
                />
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-2">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
        </div>
    </DashboardLayout>
</template>
