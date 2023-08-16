<script setup>
import Label from '@/Components/Forms/Label.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const emit = defineEmits(['close']);
const props = defineProps({
    type: String,
    show: { type: Boolean, default: false },
});

const form = useForm({
    search: '',
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Nouvelle opposition" @submit="submit" :processing="form.processing">
        <div>
            <Label>Rechercher</Label>
            <SearchField v-model="form.search" placeholder="Rechercher par numéro de carte, nom du porteur"/>
        </div>
    </ModalForm>
</template>