<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AddProductPrice from './AddProductPrice.vue';
import ProductPriceTable from './ProductPriceTable.vue';
import SettingsPartials from '@/Components/SettingsPartials.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ShoppingCartIcon } from '@heroicons/vue/24/outline';
const props = defineProps({
    product: Object,
    prices: Object,
    perpage: [String, Number],
});

const addPrice = ref(false);
</script>

<template>
    <DashboardLayout title="Infos sur le produit">
        <template #header>
            <DashboardBreadcrumb title="Infos sur le produit">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.products.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <ShoppingCartIcon class="w-5 h-5 mr-2.5" />
                        Produits
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ props.product.name }}</span>
                    </div>
                </li>
            </DashboardBreadcrumb>
        </template>

        <AddProductPrice :product="props.product" :show="addPrice == true" @close="addPrice = false" />

        <FormCard :title="`Liste des prix du produit ${props.product.name}`">
            <template #actions>
                <PrimaryButton @click.prevent="addPrice = true">Ajouter un prix</PrimaryButton>
            </template>
            <ProductPriceTable :prices="props.prices" :product="product" :perpage="props.perpage"/>
        </FormCard>
    </DashboardLayout>
</template>