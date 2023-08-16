<script setup>
import { router } from '@inertiajs/vue3';
const props = defineProps({
    url: String, 
});
function gotoLink() {
    router.visit(props.url);
}
</script>

<template>
    <tr @click.prevent="gotoLink()" class="hover:bg-gray-100 bg-white dark:hover:bg-gray-700 cursor-pointer">
        <slot />        
    </tr>
</template>