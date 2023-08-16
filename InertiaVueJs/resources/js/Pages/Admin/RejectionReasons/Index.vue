<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { BugAntIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const showCreate = ref(false);

const props = defineProps({ 
    rejectionReasons: Object, 
    perpage: [String, Number],
    filters: Object,
});
</script>

<template>
    <DashboardLayout title="Liste des motifs de raison">
        <template #header>
            <DashboardBreadcrumb title="Liste des motifs de raison">
                <BreadcrumbItem :href="route('dashboard.rejectionReasons.index')">
                    <BugAntIcon class="w-5 h-5 mr-2.5" /> Motifs de raison
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
        </template>

        <Create :show="showCreate" @close="showCreate = false" />
        
        <Table :filters="props.filters" :perpage="perpage" :rejection-reasons="props.rejectionReasons" />
    </DashboardLayout>    
</template>