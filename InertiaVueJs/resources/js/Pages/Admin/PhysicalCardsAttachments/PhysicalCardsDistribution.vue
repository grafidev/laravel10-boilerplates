<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalForm from '@/Components/ModalForm.vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Select from '@/Components/Select.vue';

const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    station_managers: Array,
});

const form = useForm({
    station_manager_id: '',
    quantity: 1,
});

const submit = () => form.post(route('dashboard.physical_cards_distribution.store'), {
    onSuccess: () => {
        close();
    }
});

const close = () => emit('close');
</script>

<template>
    <ModalForm :show="show" @close="close" title="Distribution de cartes" @submit="submit" :processing="form.processing">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <Label for="station_manager_id" required>Sélectionner un gérant</Label>
                <Select name="station_manager_id" id="station_manager_id" v-model="form.station_manager_id" required placeholder="Sélectionner un gérant">
                    <option :value="station_manager.id" :key="station_manager.id" v-for="station_manager in props.station_managers">
                        {{ station_manager.name }}
                    </option>
                </Select>
                <InputError class="mt-2" :message="form.errors.station_manager_id" />
            </div>

            <div>
                <Label for="quantity" required>Quantité</Label>
                <TextField type="number" name="quantity" id="quantity" v-model="form.quantity" required/>
                <InputError class="mt-2" :message="form.errors.quantity" />
            </div>
        </div>
    </ModalForm>
</template>