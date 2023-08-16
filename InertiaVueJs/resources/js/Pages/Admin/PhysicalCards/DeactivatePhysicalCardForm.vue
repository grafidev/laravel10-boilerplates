<script setup>
import Label from "@/Components/Forms/Label.vue";
import TextareaField from "@/Components/Forms/TextareaField.vue";
import InputError from "@/Components/InputError.vue";
import ModalForm from "@/Components/ModalForm.vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(['close']);
const props = defineProps({
    physical_card: Object,
    show: { type: Boolean, default: false },
});
const form = useForm({
    deactivation_reason: '',
});

const submit = () => {
    form.post(route('dashboard.physical_cards.deactivateCard', { physical_card: props.physical_card.id }));
    close();
};

const close = () => emit('close');
</script>
<template>
    <ModalForm :show="props.show" @close="close" :title="`Désactiver la carte de ${props.physical_card?.user?.name}`" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <Label>Carte N°</Label>
                <p class="font-bold">{{ props.physical_card.serial_number }}</p>
            </div>
            <div> 
                <Label required>Raison de la désactivation</Label>
                <TextareaField v-model="form.deactivation_reason" required/>
                <InputError :message="form.errors.deactivation_reason" class="mt-2"/>
            </div>
        </div>
    </ModalForm>
</template>