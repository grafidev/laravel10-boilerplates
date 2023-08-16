<script setup>
import { onMounted, onUnmounted, ref, computed, watch } from 'vue'; 
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    length: { type: Number, default: 5 },
    modelValue: [String, Number],
});

const inputs = ref([]);
const pincode = ref(Array.from({length: props.length}, () => ''));

const pinCodeValue = computed({
    get() {
        const value = inputs.value.map(input => input.value).join('');
        emit('update:modelValue', value);
    },
    set(newValue) {
        const parts = newValue.split('');
        if(parts.length === inputs.value.length) {
            inputs.value.forEach((input, index) => {
                input.value = parts[index];
            });
        }
    }
 });


onMounted(() => {
    inputs.value = Array.from(document.querySelectorAll('[data-input]'));

    inputs.value.forEach((input, index) => {
        input.dataset.index = index;

        input.addEventListener('keyup', handleKeyup);
        input.addEventListener('paste', handlePaste);
    });

    function handleKeyup(e) {
        if(! [0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map(i => ''+i).includes(e.key)) {
            return;
        }
        

        const input = e.target;
        let value = input.value;
        input.value = value ? value[0] : '';

        let fieldIndex = input.dataset.index;

        if(value.length > 0 && fieldIndex < inputs.value.length - 1) {
            input.nextElementSibling.focus();
        }

        if(e.key == 'Backspace' && fieldIndex > 0) {
            input.previousELementSibling.focus();
        }

        if(fieldIndex == inputs.value.length - 1) {
            submit();
            console.log('test');
        }
    }
    
    function handlePaste(e) {
        const data = e.clipboardData.getData('text');
        const value = data.split('');
        if(inputs.value.length === value.length) {
            inputs.value.forEach((input, index) => {
                input.value ='';
                input.value = value[index];
            });
            submit();
        }
    }

    function submit() {
        let value = '';
        inputs.value.forEach(input => {
            value += input.value;
            input.disabled = true;
        });

        emit('update:modelValue', value);
    }

    watch(() => props.modelValue, modelValue => {
        let value = modelValue.split('');
        if(inputs.value.length === value.length) {
            inputs.value.forEach((input, index) => {
                input.value ='';
                input.value = value[index];
            });
            submit();
        }
    });
});

</script>

<template>
    <div class="grid grid-cols-5 gap-4">
        <input 
            type="text" 
            data-input 
            maxlength="1"
            class="form-input border text-3xl border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-500 focus:border-green-500 focus:bg-white block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 text-center" 
            :key="index" v-for="(digit, index) in pincode"
            required
        >
    </div>
</template>