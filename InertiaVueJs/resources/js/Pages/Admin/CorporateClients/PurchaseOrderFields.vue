<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import Select from '@/Components/Select.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
    products: Array,
});
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <Label for="count" required>Nombre</Label>
            <TextField type="number" name="count" id="count" v-model="form.count" required />
            <InputError class="mt-2" :message="form.errors.count" />
        </div>
        
        <div>
            <Label for="product_id" required>Produit</Label>
            <Select name="product_id" id="product_id"  v-model="form.product_id" placeholder="Sélectionner un produit" required>
                <option :value="product.id" :key="product.id" v-for="product in props.products">{{ product.name }}</option>
            </Select>
            <InputError class="mt-2" :message="form.errors.product_id"/>
        </div>

        <div>
            <Label for="amount" required>Montant</Label>
            <TextField type="number" name="amount" id="amount" v-model="form.amount" required/>
            <InputError class="mt-2" :message="form.errors.amount"/>
        </div>
    </div>
</template>