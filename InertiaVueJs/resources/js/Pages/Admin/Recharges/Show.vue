<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreacrumb from '@/Components/DashboardBreadcrumb.vue';
import { Link, usePage } from '@inertiajs/vue3'
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';
import Card from '@/Components/Card.vue';
import Label from '@/Components/Forms/Label.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import UserDetailsModal from '@/Components/Users/UserDetailsModal.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import FormCard from '@/Components/FormCard.vue';
import ValidationForm from '@/Components/ValidationForm.vue';

const props = defineProps({
    recharge: Object,
});

const { auth } = usePage().props;

const showUserDetails = ref(false);
</script>

<template>
    <DashboardLayout title="Détails sur la recharge">
        <template #header>
            <DashboardBreacrumb title="Infos sur la recharge">
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard.recharges.index')" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <ArrowDownTrayIcon class="w-5 h-5 mr-2.5" />
                        Recharges
                    </Link>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Details</span>
                    </div>
                </li>
            </DashboardBreacrumb>
        </template>
        <Card>
            <div class="grid grid-cols-3 gap-2 items-start">
                <div class="col-span-2 space-y-3">
                    <FormCard title="Détails">
                        <div class="grid grid-cols-4 gap-3">
                            <div>
                                <Label>Montant</Label>
                                <p><NumberFormatter :value="recharge.data.amount" currency="XOF"/></p>
                            </div>

                            <div>
                                <Label>Bénéficiaire</Label>
                                <a href="#" @click.prevent="showUserDetails = true" class="text-green-500 underline">
                                    <p>{{ recharge.data.user?.name || '---' }}</p>
                                </a>
                                <Modal :show="showUserDetails" @close="showUserDetails = false">
                                    <UserDetailsModal :user="recharge.data.user"/>
                                </Modal>
                            </div>

                            <div>
                                <Label>Type de recharge</Label>
                                <p>{{ recharge.data.type }}</p>
                            </div>

                            <div>
                                <Label>Date de création</Label>
                                <p><DateForHumans :date="recharge.data.created_at" /></p>
                            </div>
                        </div>
                    </FormCard>
                </div>
                
                <FormCard v-if="recharge.data.rechargeStatus?.description" :title="`${recharge.data.rechargeStatus.description}`">
                    <ValidationForm v-if="auth.user.canHandle" />
                </FormCard>
            </div>
        </Card>
    </DashboardLayout>
</template>