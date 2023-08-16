<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { router } from '@inertiajs/vue3';
import { ChartBarIcon } from '@heroicons/vue/24/outline';
import Chart from '@/Components/Charts/Chart.vue';
import Card from '@/Components/Card.vue';
import Select from '@/Components/Select.vue';
import { ref, watch } from 'vue';
import BrandLoader from '@/Components/BrandLoader.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({
    transactions_chart_data: Object,
    clients_chart_data: Object,
    corporate_clients_chart_data: Object,
    total_sales_stations_chart: Object,
    most_sold_products_chart: Object,
    filters: Object,
});

const loadingChartData = ref(false);

const interval = ref(props.filters.interval);

watch(interval, interval => {
    loadingChartData.value = true;

    router.get(route('dashboard.charts.index'), { interval }, {
        onFinish: () => {
            loadingChartData.value = true;
        }
    });
});
</script>

<template>
    <DashboardLayout title="Statistiques">
        <template #header>
            <DashboardBreadcrumb title="Statistiques">
                <BreadcrumbItem :url="route('dashboard.charts.index')">
                    <ChartBarIcon class="w-5 h-5 mr-2.5" /> Statistiques
                </BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <BrandLoader :loading="loadingChartData" />

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
                    <Chart :chart="props.transactions_chart_data" />
                    <Chart :chart="props.clients_chart_data" />
                    <Chart :chart="props.corporate_clients_chart_data" />
                    <Chart :chart="props.total_sales_stations_chart" />
                    <Chart :chart="props.most_sold_products_chart" />
                </div>
            </Card>
        </div>
    </DashboardLayout>
</template>
