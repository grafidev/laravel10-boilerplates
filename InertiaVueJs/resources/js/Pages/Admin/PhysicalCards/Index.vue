<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import CreateClient from '@/Pages/Admin/Clients/Create.vue';
import Create from './Create.vue';
import PhysicalCardsDistribution from './PhysicalCardsDistribution.vue';
import Table from './Table.vue';
import { CreditCardIcon } from '@heroicons/vue/24/outline';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import ButtonDropdown from '@/Components/ButtonDropdown.vue';
import ButtonDropdownItem from '@/Components/ButtonDropdownItem.vue';

const props = defineProps({
    perpage: [String, Number],
    filters: Object,
    physical_cards: Object,
    station_managers: Array,
});

const createClient = ref(false);
const createCards = ref(false);
const distributeCards = ref(false);
const overflowTable = ref(false);

const { auth } = usePage().props;

</script>

<template>
    <DashboardLayout title="Clientèle et cartes">
        <template #header>
            <DashboardBreadcrumb title="Clientèle et cartes">
                <BreadcrumbItem :url="route('dashboard.physical_cards.index')">
                    <CreditCardIcon class="w-5 h-5 mr-2.5"/> Clientèle et cartes
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <ButtonGroup>
                <SecondaryButton v-if="auth.permissions.includes('create_client')" @click.prevent="createClient = true">Créer un client</SecondaryButton>
                <CreateClient :show="createClient" @close="createClient = false" />

                <ButtonDropdown title="Cartes..." @opened="overflowTable = false" @closed="overflowTable = true">
                    <ButtonDropdownItem v-if="auth.permissions.includes('create_physical_card')" @click.prevent="createCards = true">Créer des cartes</ButtonDropdownItem>
                    <ButtonDropdownItem @click.prevent="distributeCards = true">Emission de cartes</ButtonDropdownItem>
                </ButtonDropdown>
            </ButtonGroup>

            <Create :station_managers="props.station_managers" :show="createCards" @close="createCards = false" />
            <PhysicalCardsDistribution :station_managers="props.station_managers" :show="distributeCards" @close="distributeCards = false" />
        </template>

        <Table :perpage="props.perpage" :filters="props.filters" :physical_cards="props.physical_cards"/>
    </DashboardLayout>
</template>