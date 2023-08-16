<script setup>
import { ref } from 'vue';
import Drawer from '@/Components/Drawer.vue';
const emit = defineEmits(['resetFilters']);
import {
    FunnelIcon
} from '@heroicons/vue/24/outline';
const props = defineProps({
    filtering: {
        type: Boolean,
        default: false,
    },
    filtersCount: {
        type: Number,
        default: 0,
    }
});

const active = ref(false);

const toggleActive = () => {
    active.value = !active.value;
};


const onResetFilter = () => {
    close();
    emit('resetFilters');
};

const close = () => {
    active.value = false;
};

</script>
<template>
    <div class="relative">
        <button @click.prevent="toggleActive" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white relative">
            <span v-if="filtersCount" class="absolute text-xs w-5 h-5 bg-gray-300 -top-4 -right-2 flex items-center justify-center rounded-full">{{ filtersCount }}</span>
            <FunnelIcon class="w-6 h-6"/>
        </button>

        <Drawer :show="active" @close="active = false">
            <template #title>
                <h1 class="uppercase font-bold text-sm">Effectuer un filtre</h1>
            </template>
            <slot />
            
            <div class="text-right my-3" v-if="filtering">
                <a href="#" @click.prevent.stop="onResetFilter" class="text-red-500 underline">Réinitialiser les filtres</a>
            </div>
        </Drawer>
    </div>
</template>