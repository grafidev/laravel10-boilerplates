<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['close']);

const props = defineProps(['show']);

const form = useForm({
    quantity: 1,
});

function submit() {
    form.post(route('dashboard.physical_cards.bulkStore'), {
        onSuccess: () => {
            close();
            form.reset();
        }
    });
}
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Créer des cartes" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-full">
                <Label required for="quantity">Quantité</Label>
                <TextField type="number" id="quantity" v-model="form.quantity" required/>
                <InputError class="mt-4" :message="form.errors.quantity" />
            </div>
        </div>
    </ModalForm>
</template>