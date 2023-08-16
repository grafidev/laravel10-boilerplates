<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';

import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { SignalIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const showCreate = ref(false);

const props = defineProps({ 
    advertisements: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des publications">
        <template #header>
            <DashboardBreadcrumb title="Liste des publications">
                <BreadcrumbItem :url="route('dashboard.advertisements.index')">
                    <SignalIcon class="w-5 h-5 mr-2.5" /> Publications
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
            <Create :show="showCreate" @close="showCreate = false" />
        </template>


        <Table :filters="props.filters" :perpage="perpage" :advertisements="props.advertisements" />
    </DashboardLayout>    
</template>