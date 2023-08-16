<script setup>
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Td from '@/Components/Table/Td.vue';
import QrCode from '@/Components/QrCode.vue';
import NoRecords from '@/Components/NoRecords.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import FormCard from '@/Components/FormCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CreateCardHolder from './CreateCardHolder.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import { BuildingOffice2Icon } from '@heroicons/vue/24/outline';
import ButtonGroup from '@/Components/ButtonGroup.vue';

import DotationForm from './DotationForm.vue';
import CorporateClientTabs from './CorporateClientTabs.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import Modal from '@/Components/Modal.vue';
import CardHolderDetails from '../CardHolders/CardHolderDetails.vue';
import ModalContent from '@/Components/ModalContent.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const { auth } = usePage().props;

const props = defineProps({
    corporateClient: Object,
    cardHolders: Object,
    purchaseOrders: Object,
    products: Array,
    dotation_values: Array,
});

const createCardHolder = ref(false);
const showDotationForm = ref(false);
const showingCardHolderDetails = ref(null);
const showQrCode = ref(null);
</script>

<template>
    <DashboardLayout title="Informations du client (entreprise)">
        <template #header>
            <DashboardBreadcrumb title="Informations du client (entreprise)">
                <BreadcrumbItem :url="route('dashboard.corporate_clients.index')">
                    <BuildingOffice2Icon class="w-5 h-5 mr-2.5" /> Clients (entreprise)
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.corporateClient.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Porteurs de carte</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <CreateCardHolder :corporate_client_id="props.corporateClient.data.id" :show="createCardHolder" @close="createCardHolder = false"/>

        <div class="space-y-2">
            <CorporateClientTabs :corporate-client="props.corporateClient.data">
                <FormCard title="Porteurs de carte">
                    <template #actions>
                        <ButtonGroup>
                            <PrimaryButton @click.prevent="createCardHolder = true">Ajouter un porteur de carte</PrimaryButton>
                        </ButtonGroup>
                    </template>

                    <Table>
                        <Thead v-if="props.cardHolders.data.length">
                            <Tr>
                                <Td>Nom</Td>
                                <Td>Solde</Td>
                                <Td>Etat de la carte</Td>
                                <Td>Actions</Td>
                            </Tr>
                        </Thead>
                        <Tbody>
                            <NoRecords title="Aucun porteur de carte enregistré" v-if="props.cardHolders.data.length == 0"/>
                            <Tr v-for="cardHolder in props.cardHolders.data" :key="cardHolder.id">
                                <Td>
                                    <div v-if="cardHolder">
                                        <a href="" @click.prevent="showingCardHolderDetails = cardHolder.id" class="text-green-500 underline">{{ cardHolder.name }}</a>   
                                        <Modal :show="showingCardHolderDetails == cardHolder.id" @close="showingCardHolderDetails = null">
                                            <ModalContent :title="`À propos de ${cardHolder.name}`" @close="showingCardHolderDetails = null">
                                                <CardHolderDetails :user="cardHolder" />
                                            </ModalContent>
                                        </Modal>
                                    </div>
                                    <span v-else>---</span>
                                </Td>
                                <Td><NumberFormatter :value="cardHolder.card.balance" currency="XOF"/></Td>
                                <Td>
                                    <ActiveIcon :active="!cardHolder.card.is_blocked" />
                                </Td>
                                <Td>
                                    <ButtonGroup>
                                        <SecondaryButton @click.prevent="showQrCode = cardHolder.id">Voir carte</SecondaryButton>
                                        <PrimaryButton @click.prevent="showDotationForm = cardHolder.id">recharger carte</PrimaryButton>
                                    </ButtonGroup>

                                    <Modal :show="showQrCode == cardHolder.id" @close="showQrCode = null">
                                        <ModalContent title="code QR de la carte" @close="showQrCode = null">
                                            <div class="flex flex-col items-center gap-2">
                                                <span class="text-xl font-extrabold">{{ cardHolder.card.serial_number }}</span>
                                                <QrCode :scale="5" download print :text="cardHolder.card.crypted_number" :id="cardHolder.id" />
                                            </div>
                                        </ModalContent>
                                    </Modal>

                                    <DotationForm 
                                        :corporate-client="props.corporateClient.data" 
                                        :card-holder="cardHolder"
                                        :products="props.products" 
                                        :show="showDotationForm == cardHolder.id" 
                                        @close="showDotationForm = null"
                                    />
                                </Td>
                            </Tr>
                        </Tbody>
                    </Table>
                </FormCard>
            </CorporateClientTabs>
        </div>
    </DashboardLayout>
</template>