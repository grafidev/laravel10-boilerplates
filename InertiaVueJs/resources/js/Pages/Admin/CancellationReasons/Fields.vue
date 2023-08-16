<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-full">
            <Label for="name" required>Nom</Label>
            <TextField v-model="props.form.name" name="name" required/>
            <InputError class="mt-2" :message="props.form.errors.name" />
        </div>
    </div>
</template>