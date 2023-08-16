<script setup>
import TabLink from '@/Components/Navigation/TabLink.vue';
import Tab from '@/Components/Navigation/Tab.vue';
import TabHeader from '@/Components/Navigation/TabHeader.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
const props = defineProps({ station: Object });

</script>

<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.stations.show', { station: props.station.id })" :active="route().current('dashboard.stations.show', { station: props.station.id })">
                Informations
            </TabLink>
            <TabLink :href="route('dashboard.station_terminals.index', { station: props.station.id })" :active="route().current('dashboard.station_terminals.index', { station: props.station.id })">
                Terminaux
            </TabLink>
            <TabLink :href="route('dashboard.station_recharges.index', { station: props.station.id })" :active="route().current('dashboard.station_recharges.index', { station: props.station.id })">
                Recharges
            </TabLink>
            <TabLink :href="route('dashboard.station_transactions.index', { station: props.station.id })" :active="route().current('dashboard.station_transactions.index', { station: props.station.id })">
                Transactions
            </TabLink>
        </TabHeader>
        <TabContent>
            <slot />
        </TabContent>
    </Tab>
</template>