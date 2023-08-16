<script setup>
import Card from '../Card.vue';

const props = defineProps({
    chart: Object,
});
</script>

<template>
    <Card>
        <apexchart :width="props.chart.width" :height="props.chart.height" :type="props.chart.type" :options="props.chart.options" :series="props.chart.series"></apexchart>
    </Card>
</template>

