<script setup>
import { watch, onMounted, onUnmounted, ref, computed, nextTick } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Fuse from 'fuse.js';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import TextField from './Forms/TextField.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
});

const search = ref('');
const currentIndex = ref(0);
const dropdown = ref(null);

const links = [
    { label: 'Tableau de bord', url: route('dashboard') },
    { label: 'Accueil', url: route('dashboard') },
    { label: 'Mon profil', url: route('profile.edit') },
    { label: 'Mon compte', url: route('profile.edit') },
    { label: 'Comptes utilisateurs', url: route('dashboard.users.index') },
    { label: 'Ajouter un compte utilisateur', url: route('dashboard.users.create') },
];

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
            nextTick(() => {
                document.getElementById('spotlight')?.focus();
            })
        } else {
            document.body.style.overflow = null;
        }
    }
);

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape)
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const goTo = ({ url }) => {
    router.visit(url, { preserveScroll: true });
    close();
};

const filteredLinks = computed(() => {
    if(search.value) {
        const fuse = new Fuse(links, {
            useExtendedSearch: true,
            keys: ['label']
        });
        return fuse.search("'" + search.value).map(r => r.item);
    }
    currentIndex.value = 0;
    return [];
});

const goDown = () => {
    if(currentIndex.value >= filteredLinks.value.length - 1) {
        currentIndex.value = 0;
    } else {
        currentIndex.value++;
    }
    stayFocus();
};

const goUp = () => {
    if(currentIndex.value == 0) {
        currentIndex.value = filteredLinks.value.length - 1;
    } else {
        currentIndex.value--;
    }
    stayFocus();
};

const close = () => {
    emit('close');
};

const enter = () => {
    const link = filteredLinks.value[currentIndex.value];
    if(link) goTo(link);
    currentIndex.value = 0;
};

const stayFocus = () => {
    dropdown.value.children[currentIndex.value]?.scrollIntoView({ block: 'nearest' });
};

</script>
<template>
    <div v-if="props.show" class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center" @click.prevent="close">
        <div class="max-w-md bg-white w-full relative dark:bg-gray-700 -translate-y-40" @click.stop>
            <div class="relative min-w-[300px]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <MagnifyingGlassIcon class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                </div>
                <TextField type="search" id="spotlight" @keyup.enter="enter" @keyup.down="goDown" @keyup.up="goUp" placeholder="Où voulez vous aller?" v-model="search" class="pl-10"/>
            </div>

            <div ref="dropdown" class="absolute top-full w-full bg-white dark:bg-gray-800 left-0 min-h-0 max-h-[200px] overflow-y-auto">
                <Link :class="{ 'bg-gray-100 dark:bg-gray-700': currentIndex == index }" class="p-3 dark:text-white block w-full hover:bg-gray-100 dark:hover:bg-gray-700" @click.prevent="goTo(link)" :href="link.url" v-for="(link, index) in filteredLinks" :key="link.label">{{ link.label }}</Link>
            </div>
        </div>
    </div>
</template>