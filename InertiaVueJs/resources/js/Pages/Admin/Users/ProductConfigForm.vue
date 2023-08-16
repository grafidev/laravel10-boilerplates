<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Alert } from '@/alert';
import { useForm } from '@inertiajs/vue3';
const emit = defineEmits(['close']);
const props = defineProps({
    products: Array,
    user: Object,
    form: Object,
});

const form = useForm({
    products: props.user.products.map(p => p.id),
});

const submit = () => {
    form.post(route('dashboard.users.addProducts', { user: props.user.id }), {
        onSuccess: () => {
            close();
            Alert.success('Produits configurés avec succès.');
        }
    });
};
const close = () => emit('close');
</script>

<template>
    <div class="p-4 divide-y-2">
        <h1 class="text-xl">Configuration des produits</h1>
    </div>

    <form @submit.prevent="submit">
        <div class="p-4 grid grid-cols-3 gap-2">
            <div class="flat-checkbox" v-for="product in props.products" :key="`${props.user.id}-${product.id}`">
                <input type="checkbox" :id="`user-${props.user.id}-product-${product.id}`" v-model="form.products" :value="product.id" multiple>
                <label :for="`user-${props.user.id}-product-${product.id}`">{{ product.name }}</label>
            </div>
        </div>

        <div class="p-4 flex items-center justify-end gap-3">
            <SecondaryButton @click.prevent="close">Annuler</SecondaryButton>
            <PrimaryButton>Enregistrer</PrimaryButton>
        </div>
    </form>
</template>