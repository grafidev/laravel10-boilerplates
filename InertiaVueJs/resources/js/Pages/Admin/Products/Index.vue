<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { ShoppingCartIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import Table from './Table.vue';

const props = defineProps({
  products: Object, 
  perpage: [String, Number],
  filters: Object,
});
</script>

<template>
  <DashboardLayout title="Gestion des produits">
    <template #header>
        <DashboardBreadcrumb title="Gestion des produits">
            <BreadcrumbItem :url="route('dashboard.products.index')">
                <ShoppingCartIcon class="w-5 h-5 mr-2.5"/> Produits
            </BreadcrumbItem>
            <BreadcrumbItem>Liste</BreadcrumbItem>
        </DashboardBreadcrumb>
    </template>

    <Table
      :products="props.products"
      :filters="props.filters"
      :perpage="props.perpage"
    />
  </DashboardLayout>
</template>