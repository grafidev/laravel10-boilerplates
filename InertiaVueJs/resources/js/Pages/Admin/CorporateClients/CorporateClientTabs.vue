<script setup>
import Tab from '@/Components/Navigation/Tab.vue';
import TabLink from '@/Components/Navigation/TabLink.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
import TabHeader from '@/Components/Navigation/TabHeader.vue';

const props = defineProps({
    corporateClient: Object,
});
</script>

<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.corporate_clients.show', { corporate_client: props.corporateClient.id })" :active="route().current('dashboard.corporate_clients.show', { corporate_client: props.corporateClient.id })">
                Informations
            </TabLink>
            <TabLink :href="route('dashboard.corporate_client_card_holders.index', { corporate_client: props.corporateClient.id })" :active="route().current('dashboard.corporate_client_card_holders.index', { corporate_client: props.corporateClient.id })">
                Porteurs de carte
            </TabLink>
            <TabLink :href="route('dashboard.corporate_client_purchase_orders.index', { corporate_client: props.corporateClient.id })" :active="route().current('dashboard.corporate_client_purchase_orders.index', { corporate_client: props.corporateClient.id })">
                Bons de carburant
            </TabLink>
            <TabLink :href="route('dashboard.corporate_client_billings.index', { corporate_client: props.corporateClient.id })" :active="route().current('dashboard.corporate_client_billings.index', { corporate_client: props.corporateClient.id })">
                Facturation
            </TabLink>
        </TabHeader>
        <TabContent>
            <slot />
        </TabContent>
    </Tab>  
</template>