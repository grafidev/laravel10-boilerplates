<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
import AssignStationManager from './AssignStationManager.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import StationTabs from './StationTabs.vue';
import ModalContent from '@/Components/ModalContent.vue';
import UserDetails from '../Clients/UserDetails.vue';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const props = defineProps({ station: Object });

const assignStationManager = ref(false);
const showUserDetails      = ref(false);
</script>

<template>
    <DashboardLayout title="Informations sur la station">
        <template #header>
            <DashboardBreadcrumb title="Informations sur la station">
                <BreadcrumbItem :url="route('dashboard.stations.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5 fill-current mr-2.5">
                        <path d="M160-120v-660q0-24 18-42t42-18h269q24 0 42 18t18 42v288h65q20.625 0 35.312 14.688Q664-462.625 664-442v219q0 21.675 15.5 36.337Q695-172 717-172t37.5-14.663Q770-201.325 770-223v-295q-11 6-23 9t-24 3q-39.48 0-66.74-27.26Q629-560.52 629-600q0-31.614 18-56.807T695-690l-95-95 36-35 153 153q14 14 22.5 30.5T820-600v377q0 43.26-29.817 73.13-29.817 29.87-73 29.87T644-149.87q-30-29.87-30-73.13v-219h-65v322H160Zm60-432h269v-228H220v228Zm503-4q18 0 31-13t13-31q0-18-13-31t-31-13q-18 0-31 13t-13 31q0 18 13 31t31 13ZM220-180h269v-312H220v312Zm269 0H220h269Z"/>
                    </svg>
                    Stations
                </BreadcrumbItem>
                <BreadcrumbItem>{{ props.station.data.name }}</BreadcrumbItem>
                <BreadcrumbItem>Détails</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <AssignStationManager :station="props.station.data" :show="assignStationManager == true" @close="assignStationManager = false" />

        <div class="space-y-2">
            <StationTabs :station="props.station.data">
                <FormCard title="Informations sur la station">
                    <template #actions v-if="!station.data.manager">
                        <PrimaryButton @click.prevent="assignStationManager = true">Affecter un gérant</PrimaryButton>
                    </template>

                    <div class="grid grid-cols-4 gap-2">
                        <div v-if="station.data?.manager">
                            <Label>Gérant</Label>
                            <a href="#" @click.prevent="showUserDetails = true" class="text-green-500 underline">
                                <p>{{ station.data.manager?.name || '---' }}</p>
                            </a>

                            <Modal :show="showUserDetails" @close="showUserDetails = false">
                                <ModalContent :title="`À propos de ${station.data.manager.name}`" @close="showUserDetails = false">
                                    <UserDetails :user="station.data.manager" />
                                </ModalContent>
                            </Modal>
                        </div>

                        <div>
                            <Label>Nom</Label>
                            <p>{{ station.data.name }}</p>
                        </div>

                        <div>
                            <Label>Numéro de téléphone</Label>
                            <p>{{ station.data.phone_number }}</p>
                        </div>

                        <div>
                            <Label>Région</Label>
                            <p>{{ station.data.region }}</p>
                        </div>

                        <div>
                            <Label>Compagnie</Label>
                            <p>{{ station.data.company?.name }}</p>
                        </div>

                        <div>
                            <Label>Nombre de terminaux</Label>
                            <p>{{ station.data.terminals.length }}</p>
                        </div>
                    </div>
                </FormCard>
            </StationTabs>
        </div>
    </DashboardLayout>
</template>