<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import Fields from './Fields.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    productCategory: Object,
    show: { type: Boolean, default: false },
});

const form = useForm({
    name: props.productCategory.name,
});

function submit() {
    form.put(route('dashboard.product-categories.update', {product_category: props.productCategory.id}), {
        onSuccess: () => {
            close();
            Alert.success('Le produit a bien été modifié.');
        }
    });
}

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Modifier la catégorie de produit" :processing="form.processing">
        <Fields :form="form" />
    </ModalForm>
</template>