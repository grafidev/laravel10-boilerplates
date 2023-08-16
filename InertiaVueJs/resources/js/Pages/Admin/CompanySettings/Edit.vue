<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextField from '@/Components/Forms/TextField.vue';
import CustomerSettingsTabs from '@/Components/CustomerSettingsTabs.vue';
import FileUpload from '@/Components/Forms/FileUpload.vue';
import InputError from '@/Components/InputError.vue';
import LvColorpicker from 'lightvue/color-picker';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    companies: Array,
    settings: Object,
    app_setting: Object,
});

const form = useForm({
    app_name: props.settings.app_name || null,
    app_logo: null,
    bg_image: null,
    app_primary_color: props.settings.app_primary_color,
    app_secondary_color: props.settings.app_secondary_color,
});

const submit = () => form.post(route('dashboard.companies.app_settings.update'));
</script>

<template>
    <DashboardLayout title="Configuration">
        <template #header>
            <DashboardBreadcrumb title="Configuration générale">
                <BreadcrumbItem :url="route('dashboard.companies.settings.edit')">Configuration</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <div class="grid grid-cols-2">
                <FormCard title="Configuration générale" :shadow="false">
                    <form @submit.prevent="submit" class="space-y-4 grid grid-cols-2 gap-3">
                        <div class="col-span-full">
                            <Label for="app_name">Nom de l'application</Label>
                            <TextField v-model="form.app_name" id="app_name" autofocus />
                            <InputError :message="form.errors.app_name" />
                        </div>

                        <div class="flex items-end gap-4 col-span-full">
                            <div class="flex-1">
                                <FileUpload v-model="form.app_logo" name="app_logo">Logo de l'application</FileUpload>
                                <InputError :message="form.errors.app_logo" />
                            </div>
                            
                            <div class="w-20 border border-red-200" v-if="props.app_setting?.logo_url">
                                <img :src="props.app_setting?.logo_url" alt="logo image" class="col-span-full">
                            </div>
                        </div>

                        <div class="flex items-end gap-4 col-span-full">
                            <div class="flex-1">
                                <FileUpload v-model="form.bg_image" name="bg_image">Arrière plan de l'application</FileUpload>
                                <InputError :message="form.errors.bg_image" />
                            </div>
                            
                            <div class="w-20 border border-red-200" v-if="props.app_setting?.bg_image_url">
                                <img :src="props.app_setting?.bg_image_url" alt="bg image" class="col-span-full">
                            </div>
                        </div>

                        <div class="col-span-full">
                            <Label for="app_primary_color">Couleur primaire de l'application</Label>
                            <LvColorpicker v-model="form.app_primary_color" clearable class="w-full"/>
                            <InputError :message="form.errors.app_primary_color" />
                        </div>

                        <div class="col-span-full">
                            <Label for="app_secondary_color">Couleur secondaire de l'application</Label>
                            <LvColorpicker v-model="form.app_secondary_color" clearable class="w-full"/>
                            <InputError :message="form.errors.app_secondary_color" />
                        </div>

                        <div class="col-span-full">
                            <PrimaryButton :disabled="form.processing">Enregistrer</PrimaryButton>
                        </div>
                    </form>
                </FormCard>
            </div>
        </CustomerSettingsTabs>
    </DashboardLayout>
</template>

