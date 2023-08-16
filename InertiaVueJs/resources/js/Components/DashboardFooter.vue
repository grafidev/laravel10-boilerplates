<script setup>
import { usePage } from "@inertiajs/vue3";

const { app_name } = usePage().props;
</script>

<template>
    <footer class="bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ new Date().getFullYear() }} <a href="https://digitechsystem.net/" target="_blank" class="hover:underline">{{ app_name }}</a>. Tous droits réservés. </span>
        </div>
    </footer>
</template>