<script setup>
import DateForHumans from '@/Components/DateForHumans.vue';
import Modal from '@/Components/Modal.vue';
import ModalContent from '@/Components/ModalContent.vue';
import NoRecords from '@/Components/NoRecords.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    recharge: Object,
});

const close = () => emit('close');
</script>

<template>
    <Modal :show="props.show" @close="close">
        <ModalContent title="Historique de validation" @close="close">
            <NoRecords class="flex items-center justify-center" :colspan="1" title="Aucun élément enregistré pour le moment" v-if="props.recharge.validationHistories.length == 0" />

            <ol class="relative border-l border-gray-200 dark:border-gray-700" v-if="props.recharge.validationHistories.length">                   
                <li class="mb-10 ml-6" :key="history.id" v-for="history in props.recharge.validationHistories">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-900 dark:bg-green-900">
                        <svg aria-hidden="true" class="w-3 h-3 text-green-800 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ history.user.name }}</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"><DateForHumans :date="history.created_at" /></time>
                    
                    <div class="flex items-baseline gap-x-3 mb-3">
                        <StatusBadge :name="history.from_status.name">{{ history.from_status.description }}</StatusBadge> 
                        <span class="text-xs">vers</span> 
                        <StatusBadge :name="history.to_status.name">{{ history.to_status.description }}</StatusBadge>
                    </div>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ history.comment || '---' }}</p>
                </li>
            </ol>
        </ModalContent>
    </Modal>
</template>