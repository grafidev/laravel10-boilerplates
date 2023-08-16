<script setup>
import Label from '@/Components/Forms/Label.vue';
import Select from '@/Components/Select.vue';
import TextField from '@/Components/Forms/TextField.vue';
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    form: Object,
    products: Array,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">

        <div class="col-span-full">
            <Label for="product_id" required>Produit</Label>
            <Select name="product_id" id="product_id" v-model="form.product_id" placeholder="Sélectionner un produit" required>
                <option :value="product.id" :key="product.id" v-for="product in props.products">{{ product.name }}</option>
            </Select>
            <InputError :message="form.errors.product_id" />
        </div>

        <div class="col-span-full">
            <Label for="ttc" required>Prix TTC</Label>
            <TextField type="number" id="ttc" v-model="form.ttc" required />
            <InputError :message="form.errors.ttc" />
        </div>

        <div class="col-span-full">
            <Label for="htva" required>Prix HTVA</Label>
            <TextField type="number" id="htva" v-model="form.htva" required />
            <InputError :message="form.errors.htva" />
        </div>

        <div class="col-span-full">
            <Label for="htt" required>Prix HTT</Label>
            <TextField type="number" id="htt" v-model="form.htt" />
            <InputError :message="form.errors.htt" />
        </div>

        <div>
            <Label for="starts_at" required>Début</Label>
            <DatePicker id="starts_at" v-model="form.starts_at" required />
            <InputError :message="form.errors.starts_at" />
        </div>

        <div>
            <Label for="ends_at" required>Fin</Label>
            <DatePicker id="ends_at" v-model="form.ends_at" required />
            <InputError :message="form.errors.ends_at" />
        </div>
    </div>
</template>