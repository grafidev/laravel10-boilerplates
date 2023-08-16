<script setup>
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Select from '@/Components/Select.vue';

const props = defineProps({
    form: Object,
    users: Array,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <Label for="user_id" required>Utilisateur</Label>
            <Select name="user_id" id="user_id" v-model="props.form.user_id" placeholder="Sélectionner un utilisateur" required>
                <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
            </Select>
            <InputError class="mt-2" :message="form.errors.user_id"/>
        </div>

        <div>
            <Label for="amount" required>Montant</Label>
            <TextField name="amount" id="amount" v-model="form.amount" required />
            <InputError class="mt-2" :message="form.errors.amount"/>
        </div>
    </div>
</template>