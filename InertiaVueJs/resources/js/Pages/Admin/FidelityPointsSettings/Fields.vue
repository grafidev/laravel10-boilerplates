<script setup>
import TextField from '@/Components/Forms/TextField.vue';
import Label from '@/Components/Forms/Label.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <Label for="minimal_amount" required>Montant minimum</Label>
            <TextField type="number" id="minimal_amount"  v-model="props.form.minimal_amount" required/>
            <InputError class="mt-2" :message="props.form.errors.minimal_amount"/>
        </div>

        <div>
            <Label for="earned_points" required>Points gagnés</Label>
            <TextField type="number" id="earned_points" v-model="props.form.earned_points" required/>
            <InputError class="mt-2" :message="props.form.errors.earned_points" />
        </div>
    </div>
</template>