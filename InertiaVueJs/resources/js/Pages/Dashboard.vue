<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import WelcomeWidget from '@/Components/Widgets/WelcomeWidget.vue';
import { HomeIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import Card from '@/Components/Card.vue';
import Select from '@/Components/Select.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Chart from '@/Components/Charts/Chart.vue';

const props = defineProps({
    users_chart_data: Object,
    filters: Object,
});

const interval = ref(props.filters.interval);

watch(interval, value => {
    router.get(route('dashboard'), { interval: value });
});
</script>

<template>
    <DashboardLayout title="Tableau de bord">
        <template #header>
            <DashboardBreadcrumb title="Tableau de bord">
                <BreadcrumbItem :url="route('dashboard')">
                    <HomeIcon class="w-5 h-5 mr-2.5"/> Accueil
                </BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <div class="space-y-4 mt-4">
            <div class="grid grid-cols-2 gap-4">
                <WelcomeWidget />
            </div>

            <div class="space-y-4 mt-4 ">
                <Card>
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg">Statistiques</h4>
                        <div>
                            <Select v-model="interval" name="interval" id="interval" placeholder="Sélectionner la période">
                                <option value="day">Jour</option>
                                <option value="month">Mois</option>
                                <option value="year">Année</option>
                            </Select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-3">
                        <Chart :chart="props.users_chart_data" />
                    </div>
                </Card>
            </div>
        </div>
    </DashboardLayout>
</template>


