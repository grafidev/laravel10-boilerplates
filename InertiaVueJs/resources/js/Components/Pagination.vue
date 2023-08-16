<script setup>
import { ref, watch, computed } from 'vue';
import { Link } from "@inertiajs/vue3";
const emit = defineEmits(['onChangeTableRecordsPerPage']);
const props = defineProps({
  links: Array,
  perpage: {
    type: [String, Number],
    default: 0,
  },
  meta: {
    type: [Object, Boolean],
    default: false,
  }
})

const tableRecordsPerPage = ref(props.perpage);

watch(tableRecordsPerPage, page => {
  emit('onChangeTableRecordsPerPage', page);
});

const showPaginationLinks = computed(() => props.meta.current_page != props.meta.last_page);

</script>

<template>
  <div
    class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700"
  >
    <div class="flex items-center justify-between w-full">
      <span class="dark:text-white" v-if="props.meta.total">Affichage de {{ props.meta.from }} à {{ props.meta.to }} sur {{ props.meta.total }} résultats</span>

      <label class="mx-auto" v-if="props.meta.total">
        <select
          v-model="tableRecordsPerPage"
          class="h-8 text-sm pr-8 leading-none transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-primary-500"
        >
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100000">Tous</option>
        </select>

        <span class="text-sm font-medium dark:text-white"> par page </span>
      </label>

      <div class="py-3 border rounded-lg dark:border-gray-600 ml-auto" :class="{'invisible': meta.last_page == 1}">
        <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600" >
          <li v-for="(link, index) in links" :key="index">
            <Link
                as="button"
                :href="link.url == null ?'': link.url"
                :class="{ 'ring-2 ring-green-700 bg-green-100 dark:bg-transparent': link.active }"
                class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-green-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition"
            >
              <span v-html="link.label"></span>
            </Link>
          </li>
        </ol>
      </div>
    </div>
  </div>
</template>