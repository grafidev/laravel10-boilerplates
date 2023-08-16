<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { Link, Head } from '@inertiajs/vue3';
const props = defineProps(['title']);
</script>

<template>
    <div id="login-page"  class="login-page bg-gray-100 flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">

        <div class="fixed top-0 right-0 p-2">
            <ThemeSwitcher/>
        </div>

        <Head :title="title" />
    
        <Link href="/" class="flex text-center items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <ApplicationLogo />
        </Link>
        <!-- Card -->
        <div class="login-box bg-white border z-20 dark:border-gray-700 w-full max-w-md p-6 space-y-8 sm:p-8 border-gray-200 rounded-xl dark:bg-gray-800 shadow-xl dark:text-white">
            <slot />
        </div>
    </div>
</template>


<style>
.light-login-page {
  background-image: radial-gradient(circle at top,#fef3c7,#fff 50%);
}

.dark-login-page {
  background-image: radial-gradient(circle at top,#92400e,#1f2937,#111827 100%);
}
</style>