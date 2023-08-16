<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Select from '@/Components/Select.vue';
import DatePicker from '@/Components/Forms/DatePicker.vue'
import InputError from '@/Components/InputError.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';

const props = defineProps({
    categories: Array,
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full">
            <Label for="product_category_id" required>Catégorie</Label>
            <Select placeholder="Sélectionner une catégorie" id="product_category_id" v-model="form.product_category_id" required>
                <option :value="category.id" v-for="category in props.categories" :key="category.id">{{ category.name }}</option>
            </Select>
            <InputError class="mt-2" :message="form.errors.product_category_id"/>
        </div>

        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" required/>
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="col-span-full">
            <Label for="price">Prix</Label>
            <TextField type="number" name="price" id="price" v-model="form.price"/>
            <InputError class="mt-2" :message="form.errors.price" />
        </div>

        <div class="col-span-full">
            <Label for="notes">Notes sur le produit</Label>
            <TextareaField name="notes" id="notes" v-model="form.notes"/>
            <InputError class="mt-2" :message="form.errors.notes" />
        </div>
    </div>
</template>