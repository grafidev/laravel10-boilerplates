<script setup>
import RadioButton from './RadioButton.vue';
const props = defineProps({
    options: Array,
    name: String,
});
</script>

<template>
    <RadioButton 
        v-for="option in options" 
        :key="option.value"
        :value="option.value" 
        :name="props.name" 
        @upd
        v-model="form.product_type"
    >
        {{ product_type.label }}
    </RadioButton>
</template>