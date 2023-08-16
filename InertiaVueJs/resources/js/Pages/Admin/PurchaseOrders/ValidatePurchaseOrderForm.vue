<script setup>
import { useForm, router } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import { Alert } from '@/alert';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import Label from '@/Components/Forms/Label.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import InputError from '@/Components/InputError.vue';
import { notices } from '@/composables'
import api from '@/api';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    purchase_order: Object,
});

const form = useForm({
    notice: notices.default,
    comment: '',
});

const submit = () => {
    api().post(route('dashboard.purchase_orders.validation', { endowment: props.purchase_order.id }), {
        ...form.data(),
    }).then(data => {
        Alert.success(data.message);
        close();
        router.reload();
    }).catch(({ status, errors }) => {
        if(status === 422) {
            form.setError(errors);
        } else if(status === 500) {
            Alert.error('Erreur interne');
        } else {
            Alert.error(errors[0]);
        }
    });
}

const close = () => emit('close');

const handleChange = (value) => {
    form.notice = value;
};
</script>

<template>
    <ModalForm :show="show" @close="close" title="Validation d'un bon de carburant" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <Label required>Avis</Label>
                <RadioField 
                    v-for="notice in notices.value"
                    :key="notice.value" 
                    name="notice"
                    :id="`${notice.value}-${props.purchase_order.id}`" 
                    :value="notice.value" 
                    @change="handleChange"
                    :chosen-value="form.notice"
                    class="mb-4"
                >
                    {{ notice.label }}
                </RadioField>
                <InputError class="mt-2" :message="form.errors.notice" />
            </div>

            <div>
                <Label for="comment" :required="form.notice == 'REJETEE'">Commentaire</Label>
                <TextareaField id="comment" v-model="form.comment" :required="form.notice == 'REJETEE'"/>
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
        </div>
    </ModalForm>
</template>