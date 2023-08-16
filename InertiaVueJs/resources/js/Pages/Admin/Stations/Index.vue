<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Table from './Table.vue';
import Create from './Create.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { ref } from 'vue';
import { usePage } from "@inertiajs/vue3";
import { getRegionsFor } from '@/utils';

import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import StatsWidget from '@/Components/Widgets/StatsWidget.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const showCreate = ref(false);

const props = defineProps({
  stations: Object, 
  perpage: [String, Number],
  filters: Object,
  total_sales: Number,
  stations_count: Number,
});

const { auth } = usePage().props;

const regions = ref(getRegionsFor(auth.country?.code));
</script>

<template>
  <DashboardLayout title="Gestion des stations service">
    <template #header>
        <DashboardBreadcrumb title="Gestion des stations service">
            <BreadcrumbItem :url="route('dashboard.stations.index')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5 fill-current mr-2.5">
                    <path d="M160-120v-660q0-24 18-42t42-18h269q24 0 42 18t18 42v288h65q20.625 0 35.312 14.688Q664-462.625 664-442v219q0 21.675 15.5 36.337Q695-172 717-172t37.5-14.663Q770-201.325 770-223v-295q-11 6-23 9t-24 3q-39.48 0-66.74-27.26Q629-560.52 629-600q0-31.614 18-56.807T695-690l-95-95 36-35 153 153q14 14 22.5 30.5T820-600v377q0 43.26-29.817 73.13-29.817 29.87-73 29.87T644-149.87q-30-29.87-30-73.13v-219h-65v322H160Zm60-432h269v-228H220v228Zm503-4q18 0 31-13t13-31q0-18-13-31t-31-13q-18 0-31 13t-13 31q0 18 13 31t31 13ZM220-180h269v-312H220v312Zm269 0H220h269Z"/>
                </svg>
                Stations
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <template #actions>
      <PrimaryButton v-if="auth.permissions.includes('create_station')" @click.prevent="showCreate = true">Créer</PrimaryButton>
      <Create :show="showCreate" @close="showCreate = false" :regions="regions" />
    </template>

    <div class="grid grid-cols-3 gap-2">
      <StatsWidget :href="route('dashboard.stations.index')" title="Nombre de stations" :count="props.stations_count"/>

      <StatsWidget :href="route('dashboard.stations.index')" title="Total des ventes">
        <template #count>
          <NumberFormatter :value="props.total_sales" currency="XOF"/>
        </template>
      </StatsWidget>
    </div>

    <Table
      :stations="props.stations"
      :perpage="props.perpage"
      :filters="props.filters"
      :regions="regions"
    />
  </DashboardLayout>
</template>