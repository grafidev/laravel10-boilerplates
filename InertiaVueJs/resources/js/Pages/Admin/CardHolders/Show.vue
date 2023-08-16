<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import { router } from '@inertiajs/vue3';
import CardHolderDetails from './CardHolderDetails.vue';
import CardDetails from './CardDetails.vue';
import { UsersIcon } from '@heroicons/vue/24/outline';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { downloadQrCode } from '@/utils';
import { printQrcode } from '@/composables';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import CardHolderTabs from './CardHolderTabs.vue';

const props = defineProps({
    cardHolder: Object,
});
</script>

<template>
    <DashboardLayout :title="`Informations du porteur de carte ${cardHolder.data.name}`">
        <template #header>
            <DashboardBreadcrumb title="Informations du porteur de carte">
                <BreadcrumbItem :url="route('dashboard.card_holders.index')">
                    <UsersIcon class="w-5 h-5 mr-2.5" /> Porteurs de carte
                </BreadcrumbItem>
                <BreadcrumbItem>{{ cardHolder.data.name }}</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <PrimaryButton 
                v-if="cardHolder.data.has_endowments_to_validate"
                @click.prevent="router.visit(route('dashboard.card_holders.validationForm', { card_holder: cardHolder.data.id }))">
                Valider la dotation
            </PrimaryButton>
        </template>

        <CardHolderTabs :card_holder="cardHolder.data">
            <div class="grid grid-cols-2 gap-1"> 
                <div class="space-y-3">
                    <CardDetails :client="cardHolder.data" :card="cardHolder.data.card" />

                    <div class="flex items-center justify-center gap-2">
                        <PrimaryButton @click.prevent="downloadQrCode(`card-holder${cardHolder.data.card.id}`)">Télécharger</PrimaryButton>
                        <SecondaryButton @click.prevent="printQrcode({ id: `card-holder${cardHolder.data.card.id}` })">Imprimer</SecondaryButton>
                    </div>
                </div>

                <div class="mx-auto px-3 w-full pt-5">
                    <CardHolderDetails :user="cardHolder.data" />
                </div>
            </div>
        </CardHolderTabs>
    </DashboardLayout>
</template>