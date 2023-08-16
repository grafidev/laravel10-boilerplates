<script setup>
import { reactive, watch, onMounted } from 'vue';

const props = defineProps({tabs: Array});

const state = reactive({
  tabs: props.tabs,
  activeTab: 0,
});

watch(() => state.activeTab, tab => {
  const id = state.tabs[tab]?.id;
  window.location.hash = id;
});

onMounted(() => {
  if(! window.location.hash) return;

  const index = state.tabs.findIndex(tab => tab.id == window.location.hash?.replace('#', ''));

  if(index > -1) {
    state.activeTab = index;
  }
});

</script>

<template>
  <div class="border bg-white dark:bg-gray-800 rounded-md dark:border-gray-700 overflow-hidden">
    <div class="flex overflow-x-auto scroll-m-0 border-b dark:border-gray-600">
      <div
        v-for="(tab, index) in state.tabs"
        :key="index"
        @click="state.activeTab = index"
        :class="[
          'cursor-pointer py-4 px-8 bg-white dark:bg-gray-900 whitespace-nowrap dark:text-white hover:bg-green-100',
          state.activeTab == index ? 'text-green-700 !bg-green-100 dark:text-white dark:!bg-green-800' : '',
        ]"
      >
        {{ tab.title }}
      </div>
    </div>
    
    <div class="p-[10px]">
      <slot :name="state.tabs[state.activeTab]?.id"></slot>
    </div>
  </div>
</template>