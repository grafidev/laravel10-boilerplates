<script setup>
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Alert } from '@/alert';
import { useForm, router } from '@inertiajs/vue3';
import { notices } from '@/composables'
import StatusBadge from '@/Components/StatusBadge.vue';
import StateIndicator from '@/Components/PurchaseOrders/StateIndicator.vue';
import api from '@/api';

const props = defineProps({
    purchaseOrder: Object,
});

const form = useForm({
    notice: notices.default,
    comment: '',
});

const submit = () => form.post(route('dashboard.purchase-orders.validate', { purchaseOrder: props.purchaseOrder.id }), {
    onSuccess: () => {
        close();
        form.reset();
    }
});
</script>

<template>
    <FormCard title="Statut de validation actuel" title-centered>
        <div class="center">
            <StatusBadge :name="props.purchaseOrder?.purchase_order_status?.name"> 
                {{ props.purchaseOrder?.purchase_order_status?.description }}
            </StatusBadge>
        </div>

        <div class="mt-6">
            <form @submit.prevent="submit" class="space-y-7" v-if="! props.purchaseOrder.validation_processed">
                <div class="col-span-2">
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
    
                <div class="col-span-full">
                    <Label :required="form.notice === 'REJETEE'" for="comment">Commentaire</Label>
                    <TextareaField v-model="form.comment" id="comment" :required="form.notice === 'REJETEE'"/>
                    <InputError class="mt-2" :message="form.errors.comment" />
                </div>
    
                <div class="col-span-full">
                    <PrimaryButton type="submit">Valider</PrimaryButton>
                </div>
            </form>
            <div v-else>
                <StateIndicator>
                    <svg v-if="props.purchaseOrder?.purchase_order_status?.name == notices.reject" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <svg  v-if="props.purchaseOrder?.purchase_order_status?.name == notices.validate" xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span v-if="props.purchaseOrder?.purchase_order_status?.name == notices.reject" class="uppercase text-md text-red-600 font-bold">{{ props.purchaseOrder?.purchase_order_status?.description }}</span>
                    <span v-if="props.purchaseOrder?.purchase_order_status?.name == notices.validate" class="uppercase text-md text-green-600 font-bold">{{ props.purchaseOrder?.purchase_order_status?.description }}</span>
                </StateIndicator>
            </div>
        </div>
    </FormCard>
</template>