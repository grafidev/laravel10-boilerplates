<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormCard from '@/Components/FormCard.vue';
import { router, useForm } from '@inertiajs/vue3'; 
import RechargesTable from './RechargesTable.vue';
import CreateRecharge from './CreateRecharge.vue';
import { ref, watch } from 'vue';
import StatsWidget from '@/Components/Widgets/StatsWidget.vue';
import { changePerPage } from '@/utils';
import StationTabs from './StationTabs.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import Label from '@/Components/Forms/Label.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const props = defineProps({
    station: Object,
    terminals: Array,
    recharges: Object,
    rejectionReasons: Array,
    perpage: [String, Number],
});

const filterForm = useForm({
    search: '',
});

const createRecharge = ref(false);

const onChangePerpage = (page) => changePerPage(page, route('dashboard.station_recharges.index', { station: props.station.data.id }));

watch(() => filterForm.search, value => {
    router.get(route('dashboard.station_recharges.index', { station: props.station.data.id }), { search: value }, {
        preserveState: true,
        preserveScroll: true,
    });
});
</script>

<template>
    <DashboardLayout title="Informations sur la station">
        <template #header>
            <DashboardBreadcrumb title="Informations sur la station">
                <BreadcrumbItem :url="route('dashboard.stations.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5 fill-current mr-2.5">
                        <path d="M160-120v-660q0-24 18-42t42-18h269q24 0 42 18t18 42v288h65q20.625 0 35.312 14.688Q664-462.625 664-442v219q0 21.675 15.5 36.337Q695-172 717-172t37.5-14.663Q770-201.325 770-223v-295q-11 6-23 9t-24 3q-39.48 0-66.74-27.26Q629-560.52 629-600q0-31.614 18-56.807T695-690l-95-95 36-35 153 153q14 14 22.5 30.5T820-600v377q0 43.26-29.817 73.13-29.817 29.87-73 29.87T644-149.87q-30-29.87-30-73.13v-219h-65v322H160Zm60-432h269v-228H220v228Zm503-4q18 0 31-13t13-31q0-18-13-31t-31-13q-18 0-31 13t-13 31q0 18 13 31t31 13ZM220-180h269v-312H220v312Zm269 0H220h269Z"/>
                    </svg>
                    Stations
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.station.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Recharges</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <div class="space-y-2">
            <StationTabs :station="props.station.data">
                <div class="mb-2">
                    <StatsWidget title="Solde actuel">
                        <template #count>
                            <NumberFormatter currency="XOF" :value="station.data.manager?.wallet?.balance || 0" />
                        </template>
                        <div class="mt-3">
                            <div>
                                <Label>Etat du portefeuille</Label>
                                <ActiveIcon :active="!station.data.manager?.wallet.is_blocked"/>
                            </div>
                        </div>
                    </StatsWidget>
                </div>

                <FormCard title="Recharges">
                    <template #actions>
                        <PrimaryButton @click.prevent="createRecharge = true">Recharger</PrimaryButton>
                    </template>

                    <CreateRecharge :terminals="props.terminals" :station="props.station.data" :show="createRecharge == true" @close="createRecharge = false"/>
                    
                    <RechargesTable @on-change-perpage="onChangePerpage" :rejection-reasons="props.rejectionReasons" :station="props.station.data" :perpage="props.perpage" :recharges="props.recharges" />
                </FormCard>
            </StationTabs>
        </div>
    </DashboardLayout>
</template>