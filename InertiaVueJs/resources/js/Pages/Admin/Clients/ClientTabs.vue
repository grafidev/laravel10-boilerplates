<script setup>
import Tab from '@/Components/Navigation/Tab.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
import TabHeader from '@/Components/Navigation/TabHeader.vue';
import TabLink from '@/Components/Navigation/TabLink.vue';
const props = defineProps({ client: Object });
</script>

<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.clients.show', { id: props.client.id })" :active="route().current('dashboard.clients.show', { id: props.client.id })">Informations</TabLink>
            <TabLink :href="route('dashboard.clients.transactions', { id: props.client.id })" :active="route().current('dashboard.clients.transactions', { id: props.client.id })">Transactions</TabLink>
        </TabHeader>
        <TabContent>
            <slot />
        </TabContent>
    </Tab>
</template>