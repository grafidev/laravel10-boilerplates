<script setup>
import { computed } from 'vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextPlain from '@/Components/Forms/TextPlain.vue';
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    form: Object,
    product: Object,
});

const unit = computed(() => {
    if(props.product.product_type === 'CARBURANT') return '/ litre';
    return null;
});
</script>

<template>
    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-full">
            <Label for="product_name" required>Produit</Label>
            <TextPlain>{{ props.product.name }}</TextPlain>
        </div>

        <div>
            <Label for="ttc" required>Prix TTC {{ unit }}</Label>
            <TextField type="number" id="ttc" v-model="form.ttc" required />
            <InputError :message="form.errors.ttc" />
        </div>

        <div>
            <Label for="htva" required>Prix HTVA {{ unit }}</Label>
            <TextField type="number" id="htva" v-model="form.htva" required />
            <InputError :message="form.errors.htva" />
        </div>

        <div>
            <Label for="htt" required>Prix HTT {{ unit }}</Label>
            <TextField type="number" id="htt" v-model="form.htt" />
            <InputError :message="form.errors.htt" />
        </div>

        <div class="col-span-full grid grid-cols-2 gap-5">
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
    </div>
</template>