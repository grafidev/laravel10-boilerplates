<script setup>
import { ArrowsRightLeftIcon, BuildingOffice2Icon, FlagIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline';
import TabLink from './Navigation/TabLink.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
const { auth } = usePage().props;

const props = defineProps({
    rows: true,
});

const currentUrl = computed(() => usePage().url);
</script>
<template>
    <div class="bg-white dark:bg-gray-800">
        <div class="text-sm font-medium text-gray-500 border-b border-gray-200 dark:border-gray-800 dark:text-gray-400 overflow-hidden">
            <ul class="flex overflow-x-auto scroll-m-0 space-y-2" :class="{'flex-col': !props.rows}">
                <li class="whitespace-nowrap" v-if="false">
                    <TabLink :href="route('dashboard.settings.create')" :active="route().current('dashboard.settings.create')">Général</TabLink>
                </li>

                <li class="whitespace-nowrap" v-if="auth.permissions.includes('list_country')">
                    <TabLink :href="route('dashboard.countries.index')" :active="route().current('dashboard.countries.index')">
                        <span class="flex items-center gap-1"><FlagIcon class="w-5 h-5 mr-2"/> Pays</span>
                    </TabLink>
                </li>

                <li class="whitespace-nowrap" v-if="auth.permissions.includes('list_company')">
                    <TabLink :href="route('dashboard.companies.index')" :active="route().current('dashboard.companies.index')">
                        <span class="flex items-center gap-1"><BuildingOffice2Icon class="w-5 h-5 mr-2"/> Compagnies</span>
                    </TabLink>
                </li>

                <li class="whitespace-nowrap" v-if="auth.permissions.includes('list_product')">
                    <TabLink :href="route('dashboard.settings.products.index')" :active="currentUrl.includes('/products')">
                        <span class="flex items-center gap-1">
                            <ShoppingCartIcon class="w-5 h-5 mr-2.5"/>
                            Gestion des produits
                        </span>
                    </TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="false && auth.permissions.includes('list_price')">
                    <TabLink :href="route('dashboard.prices.index')" :active="route().current('dashboard.prices.index')">Gestion des prix</TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="false && auth.permissions.includes('list_station')">
                    <TabLink :href="route('dashboard.stations.index')" :active="route().current('dashboard.stations.index')">Gestion des stations</TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="false && auth.permissions.includes('list_card')">
                    <TabLink :href="route('dashboard.cards.index')" :active="route().current('dashboard.cards.index')">Gestion des cartes</TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="false && auth.permissions.includes('list_product')">
                    <TabLink :href="route('dashboard.products.index')" :active="route().current('dashboard.products.index')">Gestion des produits</TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="auth.permissions.includes('list_product_category')">
                    <TabLink :href="route('dashboard.product-categories.index')" :active="route().current('dashboard.product-categories.index')">Catégories de produit</TabLink>
                </li>
                <li class="whitespace-nowrap" v-if="auth.permissions.includes('list_transaction_type')">
                    <TabLink :href="route('dashboard.transaction-types.index')" :active="route().current('dashboard.transaction-types.index')">
                        <span class="flex items-center gap-1"><ArrowsRightLeftIcon class="w-5 h-5 mr-2"/> Types de transaction</span>
                    </TabLink>
                </li>
            </ul>
        </div>
    </div>
</template>