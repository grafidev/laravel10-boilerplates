<script setup>
import { Link, usePage } from '@inertiajs/vue3';
const { app_name } = usePage().props;
</script>

<template>
    <Link :href="route('dashboard')" class="flex items-center gap-5">
        <!-- <img
            src="/images/card-oil.png"
            class="h-7 dark:hidden"
            alt="Logo de free"
        />

        <img
            src="/images/card-oil-white.png"
            class="h-7 hidden dark:inline-block"
            alt="Logo de free"
        /> -->

        <span class="font-extrabold uppercase self-center text-xs tracking-widest logo-name whitespace-nowrap dark:text-white text-inherit">{{ app_name }}</span> 
    </Link>
</template>
