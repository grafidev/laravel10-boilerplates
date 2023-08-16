<script setup>
const props = defineProps({
    user: Object,
});
</script>

<template>
<div class="flex items-center gap-2">
    <img class="w-10 h-10 rounded-full" :src="user.profile_photo_url" :alt="user.name">
    <div class="text-sm font-normal">
        <div class="text-base font-semibold dark:text-white text-inherit">{{ user.name }}</div>
        <div class="text-sm font-normal dark:text-gray-400 text-inherit">{{ user.email }}</div>
        <div class="text-sm font-normal dark:text-gray-400 text-inherit">{{ user.phone_number }}</div>
    </div>
</div>
</template>