<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import Label from '@/Components/Forms/Label.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import { notices } from '@/composables';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    cancellation_request: Object,
});

const form = useForm({
    notice: notices.default,
    comment: '',
});

const submit = () => form.post(route('dashboard.cancellation_requests.validation', { id: props.cancellation_request.id }), {
    onSuccess: () => {
        form.reset();
        close();
    },
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Valider l'annulation" @submit="submit" :processing="form.processing">
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
                <Label :required="form.notice === notices.reject">Commentaire</Label>
                <TextareaField v-model="form.comment" name="comment" :required="form.notice === 'REJETEE'"/>
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
        </div>
    </ModalForm>
</template>