<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const emit = defineEmits(['countryChanged']);
const props = defineProps({
    name: String,
    id: String,
    placeholder: { type: String, default: 'Numéro de téléphone' },
    required: { type: Boolean, default: false },
    defaultCountry: { type: String, default: 'sn' },
    singleCountry: { type: Boolean, default: true },
});

const { auth } = usePage().props;

const configuredCountry = computed(() => auth.country?.code || props.defaultCountry);
const onlyCountries = computed(() => props.singleCountry ? [configuredCountry.value] : []);

const inputOptions = {
  placeholder: props.placeholder,
  name: props.name,
  id: props.id,
  required: props.required,
  separateDialcode: true,
  showDialCode: false,
  autocomplete: 'off',
};
const dropdownOptions = {
  showDialCodeInSelection: true,
  showDialCodeInList: true,
  showFlags: true,
  showSearchBox: true,
};

const countryChanged = (country) => {
  emit('countryChanged', country);
};
</script>

<template>
    <vue-tel-input 
        :input-options="inputOptions" 
        :auto-format="true"
        :default-country="configuredCountry" 
        :only-countries="onlyCountries"
        mode='international'
        :dropdown-options="dropdownOptions"
        :valid-characters-only="true"
        @country-changed="countryChanged"
    ></vue-tel-input>
</template>

<style>
.vti__dropdown-item strong {
  @apply hidden
}

.vue-tel-input {
  @apply border-none ring-1 ring-gray-300 h-[40px];
}

.dark .vue-tel-input {
  @apply bg-gray-700 ring-gray-600;
}

.vue-tel-input:focus-within {
  @apply ring-green-500 ring-2 shadow-none;
}

.dark .vti__input {
  @apply bg-gray-700;
}

.vti__selection .vti__country-code {
  @apply dark:text-gray-200;
}

.dark .vti__dropdown-list {
  @apply bg-gray-800 border border-gray-700;
}

.dark .vti__dropdown-item:hover,
.dark .vti__dropdown-item.highlighted {
  @apply bg-gray-700;
}

.vti__input:focus {
  @apply ring-green-700 ring-0 shadow-none outline-none border-none;
}

.vti__dropdown {
  @apply outline-none border-none;
}

.dark .vti__dropdown:hover {
  @apply bg-gray-700;
}

.vti__dropdown-arrow {
  @apply hidden;
}

.vti__dropdown-list {
  z-index: 9000;
}
</style>