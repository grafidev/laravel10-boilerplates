<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
const active = ref(false);
function toggleActive() {
    active.value = !active.value;
}
</script>
<template>
    <div class="w-full items-center flex justify-center relative" v-click-away="toggleActive">
        <div @click="toggleActive" class="w-10 h-10 border flex items-center justify-center rounded-full bg-gray-700 text-white cursor-pointer hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </div>

        <div v-if="active" class="text-gray-800 z-10 divide-y absolute left-0 top-[100%] min-w-[200px] bg-white border shadow">
            <Link :href="route('dashboard.order-requests.create')" class="hover:bg-gray-100  text-inherit px-3 py-2 flex text-sm">Initier une commande</Link>
        </div>
    </div>
</template>