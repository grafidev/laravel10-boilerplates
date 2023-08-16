<script setup>
import { onUnmounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import ToastListItem from '@/Components/ToastListItem.vue';
import toast from '@/Stores/toast.js';

const { flash } = usePage().props;

let removeFinishedEventListener = router.on('finish', () => {
    if(flash.mesage) {
        toast.add({ message: flash.message })
    }
});

const remove = (index) => {
    toast.remove(index);
};

onUnmounted(() => removeFinishedEventListener());
</script>

<template>
    <div class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs"> 
        <TransitionGroup
            enter-from-class="translate-x-full opacity-0"
            enter-active-class="duration-500"
            leave-active-class="duration-500"
            leave-to-class="translate-x-full opacity-0"
        >
            <ToastListItem @remove="remove(index)" :message="item.message" v-for="(item, index) in toast.items" :key="item.key" />
        </TransitionGroup>
    </div>
</template>