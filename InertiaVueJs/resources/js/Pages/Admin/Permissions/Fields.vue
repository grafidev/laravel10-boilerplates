<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: Object,
    permission: Object,
});
</script>
<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-2">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" required :disabled="props.permission?.id" />
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div class="col-span-2">
            <Label for="∂escription" required>Description</Label>
            <TextareaField name="description" id="description" v-model="form.description" required />
            <InputError class="mt-2" :message="form.errors.description"/>
        </div>
    </div>
</template>