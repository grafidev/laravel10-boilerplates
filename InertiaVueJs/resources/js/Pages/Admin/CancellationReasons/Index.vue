<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import CustomerSettingsTabs from '@/Components/CustomerSettingsTabs.vue';
import Table from './Table.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import Create from './Create.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    filters: Object,
    cancellation_reasons: Object,
    perpage: [String, Number],
});
const createReason = ref(false);

</script>

<template>
    <DashboardLayout title="Configuration">
        <template #header>
            <DashboardBreadcrumb title="Configuration générale">
                <BreadcrumbItem :url="route('dashboard.companies.cancellation_reasons.index')">Raisons d'annulation</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CustomerSettingsTabs>
            <div class="grid grid-cols-1">
                <FormCard title="Raisons d'annulation" :shadow="false">
                    <template #actions>
                        <PrimaryButton @click.prevent="createReason = true">Ajouter</PrimaryButton>
                        <Create :show="createReason" @close="createReason = false" />
                    </template>

                    <Table :cancellation_reasons="props.cancellation_reasons" :perpage="props.perpage" :filters="props.filters" />
                </FormCard>
            </div>
        </CustomerSettingsTabs>
    </DashboardLayout>
</template>