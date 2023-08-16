<script setup>
import Tab from '@/Components/Navigation/Tab.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
import TabHeader from '@/Components/Navigation/TabHeader.vue';
import TabLink from '@/Components/Navigation/TabLink.vue';

const props = defineProps({
    card_holder: Object,
});
</script>

<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.card_holders.show', { card_holder: props.card_holder.id })" :active="route().current('dashboard.card_holders.show', { card_holder: props.card_holder.id })">Informations sur le compte</TabLink>
            <TabLink :href="route('dashboard.card_holders.transactions', { card_holder: props.card_holder.id })" :active="route().current('dashboard.card_holders.transactions', { card_holder: props.card_holder.id })">Informations sur le compte</TabLink>
        </TabHeader>
        <TabContent>
            <slot />
        </TabContent>
    </Tab>
</template>