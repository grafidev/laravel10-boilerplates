<script setup>
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline';
import SecondaryButton from './SecondaryButton.vue';
import { ref, watch } from 'vue';

const emit = defineEmits(['opened', 'closed']);
const active = ref(false);

const props = defineProps({
  title: String,
  position: { type: String, default: 'left' },
});

watch(active, value => {
  emit(active ? 'opened' : 'closed', value);
});

const toggleActive = () => {
  active.value = false;
};
</script>

<template>
  <div class="relative" v-click-away="toggleActive">
    <SecondaryButton @click.prevent="active = !active">
      {{ props.title }} 
      <ChevronUpIcon v-if="active" class="w-4 h-4 ml-2" />
      <ChevronDownIcon v-else class="w-4 h-4 ml-2" />
    </SecondaryButton>
  
    <!-- Dropdown menu -->
    <div :class="[
      ' z-30 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute top-full right-0',
      active ? 'block' : 'hidden',
      props.position === 'left' ? 'right-0' : '',
      props.position === 'right' ? 'left-0' : '',
    ]">
      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
        <slot/>
      </ul>
    </div>
  </div>
</template>

