<script setup>
import UserDetails from '@/Pages/Admin/Clients/UserDetails.vue';
const props = defineProps({
    user: Object,
});
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white mb-7">
            À propos de {{ user.name }} 
        </h2>

        <UserDetails :user="props.user" />
    </div>
</template>