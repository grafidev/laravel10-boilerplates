<script setup>
import { ref } from 'vue';
const emit  = defineEmits(['handle']);
const props = defineProps({ actions: Array });
const show  = ref(false);

const onHandle = (action) => {
    toggle();
    emit('handle', action);
};
const toggle = () => {
    show.value = !show.value;
};

const onClickAway = (event) => {
    show.value = false;
};

</script>

<template>
    <div class="relative border-none" v-click-away="onClickAway">
        <button @click.prevent="toggle" class="w-8 h-8 rounded-full hover:bg-gray-100 focus:bg-gray-100 flex items-center justify-center dark:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
            </svg>  
        </button>
        <Transition name="fade">
            <div class="absolute top-full shadow-xl bg-white border z-30 rounded-md dark:bg-gray-700 dark:border-gray-600" v-if="show">
                <div v-for="action in actions" :key="action.label" class="p-1 min-w-[200px]">
                    <button class="hover:bg-green-600 text-sm w-full text-left px-3 py-1 rounded-lg hover:text-white font-bold" @click.prevent="onHandle(action)" type="button">{{ action.label }}</button>
                </div>
            </div>
        </Transition>
    </div>
</template>