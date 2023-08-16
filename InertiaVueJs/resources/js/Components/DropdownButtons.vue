<script setup>
import { initDropdowns } from 'flowbite'
import { onMounted } from 'vue';
const emit = defineEmits(['onSelect'])
const props = defineProps({
  options: Array,
  title: String,
  id: { type: String, default: 'dropdown' },
});
onMounted(() => {
  initDropdowns();
});
</script>
<template>
<button data-dropdown-placement="bottom" id="dropdownDefaultButton" :data-dropdown-toggle="id" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">{{ props.title }}<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
<div :id="id" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute left-0">
  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
    <li v-for="option in props.options" :key="option.label">
      <a :href="option.url" @click.prevent="$emit('onSelect', option)" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ option.label }}</a>
    </li>
  </ul>
</div>
</template>