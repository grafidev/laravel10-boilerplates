<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Select from '@/Components/Select.vue';
import Toggle from '@/Components/Forms/Toggle.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    station_managers: { type: Array, default: [] },
});

const form = useForm({
    quantity: 1,
    station_manager_id: null,
    distribute: false,
});

const submit = () => {
    form.post(route('dashboard.physical_cards.bulkStore'), {
        onSuccess: () => {
            close();
            form.reset();
        }
    });
};
const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Créer des cartes" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-full">
                <Label required for="quantity">Quantité</Label>
                <TextField type="number" id="quantity" v-model="form.quantity" required/>
                <InputError class="mt-2" :message="form.errors.quantity" />
            </div>

            <div class="col-span-full">
                <Toggle v-model="form.distribute">Affecter un gérant</Toggle>
            </div>

            <div class="col-span-full" v-if="form.distribute">
                <Label for="station_manager_id" :required="form.distribute">Sélectionner le gérant</Label>
                <Select id="station_manager_id" v-model="form.station_manager_id" placeholder="Sélectionner le gérant" :required="form.distribute">
                    <option :key="station_manager.id" :value="station_manager.id" v-for="station_manager in props.station_managers">{{ station_manager.name }} - {{ station_manager.station.name }}</option>
                </Select>
                <InputError class="mt-2" :message="form.errors.quantity" />
            </div>
        </div>
    </ModalForm>
</template>