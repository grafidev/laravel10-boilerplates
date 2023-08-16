<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Th from '@/Components/Table/Th.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import NoRecords from '@/Components/NoRecords.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import EditProductPrice from './EditProductPrice.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { usePage, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { changePerPage } from '@/utils';
import { Alert } from '@/alert';
import DateForHumans from '@/Components/DateForHumans.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';

const props = defineProps({
    product: Object,
    prices: Object,
    perpage: [String, Number],
    settings: Object,
});

const { auth } = usePage().props;
const search = ref('');

const editingPrice = ref(null);

const onChangePerPage = (page) => {
    changePerPage(page, route('dashboard.products.show', { product: props.product.id }));
}; 

const deletePrice = (price) => {
    Alert.confirm('Vous êtes sûr.e?').then(result => {
        if(! result.isConfirmed) {
            return;
        }
        router.delete(route('dashboard.productPrices.destroy', { product: props.product.id, price: price.id }), {
            onSuccess: () => Alert.success('Suppression effectuée avec succès.')
        });
    })
};

watch(search, value => {
    router.get(route('dashboard.products.show', { product: props.product.id }), { search: value }, {
        preserveState: true,
        preserveScroll: true,
    });
});
</script>

<template>
    <SearchWrapper>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher..." />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.prices.data.length">
            <Tr>
                <Th><SortableLink label="Prix HTT" attribute="htt" /></Th>
                <Th><SortableLink label="Prix HTVA" attribute="htva" /></Th>
                <Th><SortableLink label="Prix TTC" attribute="ttc" /></Th>
                <Th><SortableLink label="Début" attribute="starts_at" /></Th>
                <Th><SortableLink label="Fin" attribute="ends_at" /></Th>
                <Th>Actions</th>
            </Tr>
        </Thead>

        <Tbody>
            <NoRecords colspan="6" v-if="props.prices.data.length == 0" title="Aucun prix configuré"/>
            <Tr v-for="price in props.prices.data" :key="price.id">
                <Td><NumberFormatter :value="price.htt" currency="XOF" /></Td>
                <Td><NumberFormatter :value="price.htva" currency="XOF" /></Td>
                <Td><NumberFormatter :value="price.ttc" currency="XOF" /></Td>
                <Td><DateForHumans :time="false" :date="price.starts_at"/></Td>
                <Td><DateForHumans :time="false" :date="price.ends_at"/></Td>
                <Td>
                    <div class="flex items-center gap-2">
                        <PrimaryButton v-if="auth.permissions.includes('edit_price')" type="button" @click="editingPrice = price.id">
                            Modifier
                        </PrimaryButton>
                        <DangerButton v-if="auth.permissions.includes('delete_price')" @click.prevent="deletePrice(price)">Supprimer</DangerButton>
                    </div>
                    <EditProductPrice :settings="props.settings" :show="editingPrice == price.id" @close="editingPrice = null" :price="price" :product="props.product"/>
                </Td>
            </Tr>
        </Tbody>
    </Table> 

    <Pagination :meta="props.prices.meta" :perpage="perpage" @on-change-table-records-per-page="onChangePerPage" :links="props.prices.meta.links" />
</template>
