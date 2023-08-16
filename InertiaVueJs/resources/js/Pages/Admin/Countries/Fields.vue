<script setup>
import Label from '@/Components/Forms/Label.vue'
import Select from '@/Components/Select.vue';
import InputError from '@/Components/InputError.vue';
import { isoToEmoji } from '@/utils';

const props = defineProps({
    form: Object,
    countriesList: Array,
    id: String,
});
</script>

<template>
    <div class="grid grid-cols-1 gap-5">
        <div>
            <Label for="code" required>Pays</Label>
            <Select v-model="form.code" name="code" id="code" placeholder="Sélectionner un pays" required>
                <option v-for="country in props.countriesList" :key="country.value" :value="country.value">
                    {{ isoToEmoji(country.value) }}  {{ country.label }}
                </option>
            </Select>
            <InputError class="mt-2" :message="form.errors.code"/>
        </div>
    </div>
</template>