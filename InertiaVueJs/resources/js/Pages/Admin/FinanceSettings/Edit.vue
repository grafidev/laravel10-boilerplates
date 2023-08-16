<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Fieldset from '@/Components/Fieldset.vue';
import HelpText from '@/Components/Forms/HelpText.vue';
import CustomerSettingsTabs from '@/Components/CustomerSettingsTabs.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    companies: Array,
    settings: Object,
});

const form = useForm({
    tax_rate: props.settings.tax_rate || 18,
});

const submit = () => form.put(route('dashboard.companies.finances.update'));
</script>

<template>
    <DashboardLayout title="Paramètres financiers">
        <template #header>
            <DashboardBreadcrumb title="Paramètres financiers">
                <BreadcrumbItem :url="route('dashboard.companies.finances.edit')">Paramètres financiers</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <div class="grid grid-cols-2">
                <FormCard title="Paramètres financiers" :shadow="false">
                    <form @submit.prevent="submit" class="space-y-4">
                        <Fieldset title="Taxes" :toggleable="false">
                            <div>
                                <Label for="tax_rate">Taxe sur la Valeur Ajoutée (TVA) en %</Label>
                                <TextField type="number" name="tax_rate" id="tax_rate" v-model="form.tax_rate" autofocus/>
                                <HelpText>Taxe sur la valeur ajoutée</HelpText>
                            </div>
                        </Fieldset>
    
                        <div>
                            <PrimaryButton :disabled="form.processing">Enregistrer</PrimaryButton>
                        </div>
                    </form>
                </FormCard>
            </div>
        </CustomerSettingsTabs>
    </DashboardLayout>
</template>