<script setup>
import TabLink from '@/Components/Navigation/TabLink.vue';
import Tab from '@/Components/Navigation/Tab.vue';
import TabHeader from '@/Components/Navigation/TabHeader.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
</script>
<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.companies.settings.edit')" :active="route().current('dashboard.companies.settings.edit')">
                Général
            </TabLink>

            <TabLink :href="route('dashboard.companies.finances.edit')" :active="route().current('dashboard.companies.finances.edit')">
                Paramètres financiers
            </TabLink>

            <TabLink :href="route('dashboard.companies.ticket_infos.edit')" :active="route().current('dashboard.companies.ticket_infos.edit')">
                Informations sur le ticket
            </TabLink>

            <TabLink :href="route('dashboard.companies.cancellation_reasons.index')" :active="route().current('dashboard.companies.cancellation_reasons.index')">
                Raisons d'annulation
            </TabLink>

            <TabLink :href="route('dashboard.companies.rejection_reasons.index')" :active="route().current('dashboard.companies.rejection_reasons.index')">
                Motifs de rejet
            </TabLink>
        </TabHeader>

        <TabContent>
            <slot />
        </TabContent>
    </Tab>
</template>