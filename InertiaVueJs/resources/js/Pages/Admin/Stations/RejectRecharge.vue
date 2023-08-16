<script setup>
import { useForm } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import ModalForm from '@/Components/ModalForm.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import Label from '@/Components/Forms/Label.vue';
import Select from '@/Components/Select.vue';
import InputError from '@/Components/InputError.vue';
import { router } from '@inertiajs/vue3';
import api from '@/api';
import { notices } from '@/composables';

const emit = defineEmits(['close']);
const props = defineProps({
    show: { type: Boolean, default: false },
    recharge: Object,
    station: Object,
    rejectionReasons: Array,
});

const form = useForm({
    notice: notices.reject,
    rejection_reason_id: '',
    comment: '',
});

const submit = () => {
    api().post(route('dashboard.stations.recharges.validation', { recharge: props.recharge.id }), {
        ...form.data(),
    }).then(data => {
        Alert.success(data.message);
        close();
        router.reload();
        form.reset();
    }).catch(({ status, errors }) => {
        if(status == 422) {
            form.setError(errors);
        } else if(status == 500) {
            Alert.error('Erreur interne');
        } else {
            Alert.error(errors[0]);
        }
    });
};

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" @submit="submit" title="Rejet" :processing="form.processing">
        <div class="grid grid-cols-2 gap-5">
            <div class="col-span-full">
                <Label for="rejection_reason_id" required>Raison de rejet</Label>
                <Select name="rejection_reason_id" id="rejection_reason_id" v-model="form.rejection_reason_id" placeholder="Sélectionner une raison" required>
                    <option :value="rejectionReason.id" :key="rejectionReason.id" v-for="rejectionReason in props.rejectionReasons">
                        {{ rejectionReason.name }}
                    </option>
                </Select>
                <InputError class="mt-2" :message="form.errors.rejection_reason_id" />
            </div>

            <div class="col-span-full">
                <Label for="comment" required>Note</Label>
                <TextareaField name="comment" id="comment" v-model="form.comment" required />
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
        </div>
    </ModalForm>
</template>