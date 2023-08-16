<script setup>
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline';
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    showPassword: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);
const isPasswordShown = ref(props.showPassword);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

watch(() => props.showPassword, value => {
    isPasswordShown.value = value;
});

const inputType = computed(() => isPasswordShown.value ? 'text' : 'password');

const togglePasswordShown = () => {
    isPasswordShown.value = !isPasswordShown.value;
    input.value.focus();
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="flex relative border focus-within:ring-1 bg-white border-gray-300 text-gray-900 sm:text-sm rounded-lg focus-within:ring-green-500 focus-within:border-green-500 focus-within:bg-white w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus-within:ring-green-500 dark:focus-within:border-green-500">
        <input
            :type="inputType"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            style="all: unset; width: 100%; height: 100%;position: absolute; top: 0;bottom:0;left: 0;padding-left: 10px;"
            :required="props.required"
        />

        <div class="cursor-pointer ml-auto z-10" @click.prevent="togglePasswordShown">
            <EyeIcon class="w-5 h-5" v-if="isPasswordShown"/>
            <EyeSlashIcon class="w-5 h-5" v-else />
        </div>
    </div>
</template>

