<script setup>
import ModalForm from '@/Components/ModalForm.vue';
import InputError from '@/Components/InputError.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import Label from '@/Components/Forms/Label.vue';
import { notices } from '@/composables';


const emit = defineEmits(['close', 'submit']);

const props = defineProps({
    show: { type: Boolean, default: false },
    selectedPurchaseOrders: Array,
    form: Object,
});

const submit = () => emit('submit');

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Valider les Bons de carburant" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <Label required>Avis</Label>
                <RadioField 
                    v-for="notice in notices.value"
                    :key="notice.value" 
                    name="notice"
                    :id="notice.value" 
                    :value="notice.value" 
                    @change="value => form.notice = value"
                    :chosen-value="form.notice"
                    class="mb-4"
                >
                    {{ notice.label }}
                </RadioField>
                <InputError class="mt-2" :message="form.errors.notice" />
            </div>

            <div>
                <Label for="comment" :required="form.notice === 'REJETEE'">Commentaire</Label>
                <TextareaField id="comment" v-model="form.comment" :required="form.notice === 'REJETEE'"/>
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
        </div>
    </ModalForm>
</template>