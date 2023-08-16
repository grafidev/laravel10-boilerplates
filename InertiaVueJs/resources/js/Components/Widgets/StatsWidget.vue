<script setup>
import Linkable from '@/Components/Linkable.vue';
const props = defineProps({
  title: String,
  count: Number,
  amount: { type: Boolean, default: false },
  href: { type: String, default: '' },
  description: { type: String, default: ''},
});

</script>
<template>
  <Linkable
    :href="props.href"
    :class="{ 'dark:hover:border-green-500': props.href }"
    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800"
  >
    <div class="w-full">
      <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">{{ props.title }}</h3>

      <span v-if="$slots.count" class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
       <slot name="count"/>
      </span>
      
      <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
        {{ props.count }}
      </span>

      <p v-if="props.description" class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
        {{ props.description }}
      </p>
      <slot />
    </div>
  </Linkable>
</template>