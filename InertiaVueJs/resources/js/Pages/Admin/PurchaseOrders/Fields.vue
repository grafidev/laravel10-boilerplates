<script setup>
import Label from '@/Components/Forms/Label.vue';
import Select from '@/Components/Select.vue';
import DatePicker from '@/Components/Forms/DatePicker.vue';
import InputError from '@/Components/InputError.vue';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
const cancel = () => {
    router.visit(route('dashboard.purchase_orders.index'));
};
const props = defineProps({
    form: Object,
    corporate_clients: Array,
    clients: Array,
});

const isParticular = computed(() => {
    return props.form.profile_type === 'particulier';
});
const isProfessionnal = computed(() => {
    return props.form.profile_type === 'professionnel';
});
</script>

<template>
    <div class="grid grid-cols-3 gap-5">
        <div>
            <Label for="profile_type" required>Sélectionner le type de profil</Label>
            <Select v-model="form.profile_type" name="profile_type" id="profile_type" placeholder="Sélectionner le type de profil">
                <option value="particulier">Particulier</option>
                <option value="professionnel">Professionnel</option>
            </Select>
            <InputError :message="form.errors.profile_type" />
        </div>

        <div v-if="isParticular">
            <Label for="client_id" :required="isParticular">Client</Label>
            <Select name="client_id" id="client_id" placeholder="Sélectionner un client" :required="isParticular">
                <option :value="client.id" :key="client.id" v-for="client in props.clients">{{ client.name }}</option>
            </Select>
            <InputError :message="form.errors.client_id" />
        </div>

        <div v-if="isProfessionnal">
            <Label for="corporate_client_id" :required="isProfessionnal">Entreprise</Label>
            <Select name="corporate_client_id" id="corporate_client_id" placeholder="Sélectionner une entreprise" :required="isProfessionnal">
                <option :value="client.id" :key="client.id" v-for="client in props.corporate_clients">{{ client.name }}</option>
            </Select>
            <InputError :message="form.errors.corporate_client_id" />
        </div>

        <div v-if="form.profile_type">
            <Label for="expiration_date" required>Date d'expiration</Label>
            <DatePicker v-model="form.expiration_date" name="expiration_date" id="expiration_date"/>
            <InputError :message="form.errors.expiration_date" />
        </div>
    </div>
</template>