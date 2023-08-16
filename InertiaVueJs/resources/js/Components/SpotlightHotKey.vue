<script setup>
import { usePage } from '@inertiajs/vue3';
import Keyboard from './Keyboard.vue';
const { isMac } = usePage().props;
</script>

<template>
    <p class="text-gray-500 dark:text-gray-300" v-tippy="{content: 'Navigation rapide'}">
        <Keyboard>{{ isMac ? '⌘' : 'Ctrl' }}</Keyboard>&nbsp;&nbsp;<Keyboard>k</Keyboard>&nbsp;&nbsp;&nbsp;&nbsp;Recherche Spotlight <span class="text-sm inline-block ml-2"></span>
    </p>
</template>