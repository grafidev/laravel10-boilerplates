<script setup>
import { computed, ref } from 'vue';
import { isImageFile } from '@/utils';
import Modal from './Modal.vue';

const props = defineProps({ 
    name: String, 
    url: String, 
    class: String
});

const showDocument = ref(false);

const isImage = computed(() => isImageFile(props.url.toLowerCase()));

const className = computed(() => [props.class ? props.class : 'p-2 rounded-full bg-gray-100 dark:bg-gray-700']);

</script>

<template>
    <a v-if="isImage" :class="className" :href="props.url" :data-lightbox="props.name" :data-title="props.name">
        <slot/>
    </a>

    <div v-else>
        <button :class="className" @click.prevent="showDocument = true"><slot /></button>
        <Modal :show="showDocument" @close="showDocument = false">
            <iframe :src="props.url" width="100%" height="100%" frameborder="0"></iframe>
        </Modal>
    </div>
</template>