<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Fieldset from '@/Components/Fieldset.vue';
import CustomerSettingsTabs from '@/Components/CustomerSettingsTabs.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    heading: props.settings.heading || '',
    footer: props.settings.footer || '',
    greeting: props.settings.greeting || '',
});

const submit = () => form.put(route('dashboard.companies.ticket_infos.update'));
</script>

<template>
    <DashboardLayout title="Informations sur le ticket">
        <template #header>
            <DashboardBreadcrumb title="Informations sur le ticket">
                <BreadcrumbItem :url="route('dashboard.companies.ticket_infos.edit')">Informations sur le ticket</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <div class="grid grid-cols-2">
                <FormCard title="Informations sur le ticket" :shadow="false">
                    <form @submit.prevent="submit" class="space-y-4">
                        <Fieldset title="Informations sur le ticket" :toggleable="false">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <Label for="heading">Haut de page</Label>
                                    <TextField type="text" name="heading" id="heading" v-model="form.heading" autofocus />
                                    <InputError :message="form.errors.heading" class="mt-2" />
                                </div>
    
                                <div>
                                    <Label for="footer">Bas de page</Label>
                                    <TextField type="text" name="footer" id="footer" v-model="form.footer" />
                                    <InputError :message="form.errors.footer" class="mt-2" />
                                </div>

                                <div>
                                    <Label for="greeting">Formule de remerciement</Label>
                                    <TextField type="text" name="greeting" id="greeting" v-model="form.greeting" />
                                    <InputError :message="form.errors.greeting" class="mt-2" />
                                </div>
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