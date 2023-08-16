<script setup>
import Label from '@/Components/Forms/Label.vue'
import RadioField from '@/Components/Forms/RadioField.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import Select from '@/Components/Select.vue';

const props = defineProps({
    form: Object,
    terminals: Array,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-full flex items-center gap-4">
            <RadioField name="user_type" id="gerant" value="GERANT_STATION" :chosen-value="form.user_type" @change="value => form.user_type = value">Gérant</RadioField>
            <!-- <RadioField name="user_type" id="pompiste" value="POMPISTE" :chosen-value="form.user_type" @change="value => form.user_type = value">Pompiste</RadioField> -->
        </div>

        <div class="col-span-full" v-if="form.user_type === 'POMPISTE'">
            <Label for="terminal_id">Sélectionner un terminal</Label>
            <Select id="terminal_id" v-model="form.terminal_id" placeholder="Sélectionner un terminal">
                <option :value="terminal.id" :key="terminal.id" v-for="terminal in props.terminals">{{ terminal.name }}</option>
            </Select>
            <InputError class="mt-2" :message="props.form.errors.terminal_id" />
        </div>

        <div class="col-span-full">
            <Label for="amount" required>Montant</Label>
            <TextField type="number" name="amount" id="amount" v-model="form.amount" required />
            <InputError class="mt-2" :message="form.errors.amount" />
        </div>
    </div>
</template>