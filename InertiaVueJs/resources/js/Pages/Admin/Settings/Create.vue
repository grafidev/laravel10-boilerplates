<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Select from '@/Components/Select.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue';
import { Link, usePage, useForm } from "@inertiajs/vue3";
import { Alert } from '@/alert';
import Fieldset from '@/Components/Fieldset.vue';

const props = defineProps({ 
    settings: Object ,
    countries: Array,
});

const { auth } = usePage().props;

const form = useForm({
    country_id: props.settings.country_id,
    password_validity_duration: props.settings.password_validity_duration,
});

const submit = () => {
    form.post(route('dashboard.settings.store'), {
        onSuccess: () => {
            Alert.success('Mise à jour effectuée avec succès.');
            window.location.reload();
        }
    });
};
</script>

<template>
  <DashboardLayout title="Général">
    <template #header>
        <DashboardBreadcrumb title="Général">
            <li class="inline-flex items-center">
                <Link :href="route('dashboard.settings.create')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                    Configuration
                </Link>
            </li>

            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Général</a>
                </div>
            </li>
        </DashboardBreadcrumb>
    </template>

    <SettingsPartials>
        <div class="p-4 bg-white grid grid-cols-2 gap-4 dark:bg-gray-800 w-full">
            <form class="grid grid-cols-1 gap-5" @submit.prevent="submit">

                <div>
                    <Label for="password_validity_duration">Durée de validité du mot de passe</Label>
                    <Select id="password_validity_duration" name="password_validity_duration" v-model="form.password_validity_duration">
                        <option value="30">30 jours</option>
                        <option value="90">90 jours</option>
                    </Select>
                </div>

                <div>
                    <PrimaryButton type="submit">Enregistrer</PrimaryButton>
                </div>
            </form>
        </div>
    </SettingsPartials>
  </DashboardLayout>
</template>