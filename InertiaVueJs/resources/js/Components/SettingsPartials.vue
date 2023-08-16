<script setup>
import TabHeader from '@/Components/Navigation/TabHeader.vue';
import Tab from '@/Components/Navigation/Tab.vue';
import TabContent from '@/Components/Navigation/TabContent.vue';
import TabLink from '@/Components/Navigation/TabLink.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowsRightLeftIcon, BuildingOffice2Icon, Cog8ToothIcon, FlagIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline';
const page = usePage();
</script>
<template>
    <Tab>
        <TabHeader>
            <TabLink :href="route('dashboard.countries.index')" :active="route().current('dashboard.countries.index')">
                <span class="flex items-center gap-1">
                    <FlagIcon class="w-5 h-5 mr-2.5"/> Pays
                </span>
            </TabLink>
            <TabLink :href="route('dashboard.companies.index')" :active="route().current('dashboard.companies.index')">
                <span class="flex items-center gap-1">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5"/> Compagnies
                </span>
            </TabLink>
            <TabLink :href="route('dashboard.settings.products.index')" :active="page.url.includes('/products')">
                <span class="flex items-center gap-1">
                    <ShoppingCartIcon class="w-5 h-5 mr-2.5"/> Gestion des produits
                </span>
            </TabLink>
            <TabLink :href="route('dashboard.transaction-types.index')" :active="route().current('dashboard.transaction-types.index')">
                <span class="flex items-center gap-1"><ArrowsRightLeftIcon class="w-5 h-5 mr-2"/> Types de transaction</span>
            </TabLink>
        </TabHeader>

        <TabContent>
            <slot />
        </TabContent>
    </Tab>
</template>