<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AddProductPrice from './AddProductPrice.vue';
import ProductPriceTable from './ProductPriceTable.vue';
import FormCard from '@/Components/FormCard.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ShoppingCartIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
const props = defineProps({
    product: Object,
    prices: Object,
    perpage: [String, Number],
    settings: Object,
});

const addPrice = ref(false);
</script>

<template>
    <DashboardLayout title="Infos sur le produit">
        <template #header>
            <DashboardBreadcrumb title="Infos sur le produit">
                <BreadcrumbItem :url="route('dashboard.products.index')">
                    <ShoppingCartIcon class="w-5 h-5 mr-2.5" /> Produits
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.product.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <AddProductPrice :settings="props.settings" :product="props.product" :show="addPrice == true" @close="addPrice = false" />

        <FormCard :title="`Liste des prix du produit ${props.product.name}`">
            <template #actions>
                <PrimaryButton @click.prevent="addPrice = true">Ajouter un prix</PrimaryButton>
            </template>

            <ProductPriceTable :prices="props.prices" :product="product" :perpage="props.perpage" :settings="props.settings"/>
        </FormCard>
    </DashboardLayout>
</template>