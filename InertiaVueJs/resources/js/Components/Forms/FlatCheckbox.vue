<script setup>
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: [String, Number, Boolean],
    id: String,
    name: String,
    value: String,
    multiple: { type: Boolean, default: false },
});
</script>

<template>
    <div class="flat-checkbox">
        <input 
            type="checkbox" 
            :id="props.id" 
            @change="emit('update:modelValue', $event.target.value)" 
            :checked="props.modelValue == props.value" 
            :value="props.value" 
            :multiple="props.multiple">
        <label :for="props.id"><slot/></label>
    </div>
</template>
