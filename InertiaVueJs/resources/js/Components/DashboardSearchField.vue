<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import debounce from 'lodash/debounce';
import api from '@/api';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import TextField from './Forms/TextField.vue';

const search = ref('');
const show = ref(false);
const loading = ref(false);
const searchResults = ref([]);

watch(search, debounce((value) => {
    loading.value = true;
    api().get(route('dashboard.search.index', { search: value })).then(data => {
        searchResults.value = data;
    }).finally(_ => {
        loading.value = false;
    });
}, 500));

const showResult = computed(() => search.value.length > 0);
</script>

<template>
    <div class="relative" v-click-away="show = false">
        <div class="relative min-w-[300px]">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <MagnifyingGlassIcon class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
            </div>
            <TextField type="search" v-model="search" class="pl-10" placeholder="Rechercher..."/>
        </div>
        <div class="absolute top-full w-full max-h-[300px] overflow-auto mt-2" v-if="showResult">
            <div :key="key" v-for="key in Object.keys(searchResults)" class="bg-white dark:bg-gray-800 min-w-full border dark:border-gray-700 shadow-lg dark:shadow-none dark:[color-scheme:dark]">
                <ul class="divide-y dark:divide-gray-700">
                    <li class="p-2 bg-green-700 text-white dark:bg-gray-700 dark:text-white uppercase font-extrabold text-xs">{{ key }}</li>
                    <li v-for="searchResult in searchResults[key]" :key="searchResult.url">
                        <Link :href="searchResult.url" class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 flex flex-col whitespace-nowrap">
                            <span class="text-sm dark:text-white">{{ searchResult.title }}</span>
                        </Link>
                    </li>
                </ul>
            </div> 
            
            <div v-if="Object.keys(searchResults).length == 0" class="bg-white dark:bg-gray-800 min-w-full border dark:border-gray-700 shadow-lg dark:shadow-none dark:[color-scheme:dark]">
                <ul class="divide-y dark:divide-gray-700">
                    <li v-html="loading ? 'recherche en cours...' : `Aucun résultat pour <strong class='text-green-600'>${search}</strong>`" class="p-1"></li>
                </ul>
            </div>
        </div>
    </div>
</template>