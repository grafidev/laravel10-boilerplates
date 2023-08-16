<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Select from '@/Components/Select.vue';
import DatePicker from '@/Components/Forms/DatePicker.vue'
import InputError from '@/Components/InputError.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import RadioButton from '@/Components/Forms/RadioButton.vue';
import Toggle from '@/Components/Forms/Toggle.vue';

const props = defineProps({
    form: Object,
    product: Object,
});

const product_types = [
    { label: 'Carburant', value: 'CARBURANT', name: 'product_type' },
    { label: 'Autres', value: 'AUTRES', name: 'product_type' },
];
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="product_type" required>Type de produit</Label>
            <div class="grid grid-cols-1 gap-4">
                <RadioButton 
                    v-for="product_type in product_types" 
                    :key="product_type.value"
                    :value="product_type.value" 
                    :name="product_type.name" 
                    v-model="form.product_type"
                >
                    {{ product_type.label }}
                </RadioButton>
            </div>
        </div>

        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField name="name" id="name" v-model="form.name" required/>
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="col-span-full">
            <Label for="notes">Notes sur le produit</Label>
            <TextareaField name="notes" id="notes" v-model="form.notes"/>
            <InputError class="mt-2" :message="form.errors.notes" />
        </div>

        <div class="col-span-full">
            <Toggle v-model="form.active">Activer</Toggle>
        </div>
    </div>
</template>