<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue';
import PasswordField from '@/Components/Forms/PasswordField.vue';
import PinCodeField from '@/Components/Forms/PinCodeField.vue';
import { computed } from 'vue';

const props = defineProps({
    user: Object,
    token: String,
    use_pin: { type: Boolean, default: false },
});

const form = useForm({
    username: props.user.email,
    password: '',
    password_confirmation: '',
    pin: props.use_pin,
});

const submit = () => {
    form.put(route('new-password.update', { id: props.user.id, token: props.token }), {
        onFinish: () => {
            form.password = '';
            form.password_confirmation = '';
        },
    });
};

const buttonDisabled = computed(() => {
    return form.processing || (form.pin ? form.password.length < 5 : false);
})
</script>

<template>
    <GuestLayout title="Nouveau mot de passe">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Nouveau mot de passe
        </h2>

        <form class="mt-8 space-y-6" action="#" @submit.prevent="submit">
            <div>
                <Label for="username">Identifiant</Label>
                <TextField type="username" name="username" id="username" v-model="form.username" disabled/>
                <InputError class="mt-2" :message="form.errors.username"/>
            </div>

            <div v-if="form.pin">
                <Label required>Mot de passe</Label>
                <PinCodeField
                    v-model="form.password"
                />
            </div>

            <div v-if="!form.pin">
                <Label for="password" required>Mot de passe</Label>
                <PasswordField name="password" id="password" v-model="form.password" required />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            
            <div v-if="!form.pin">
                <Label for="password_confirmation" required>Confirmez le mot de passe</Label>
                <PasswordField name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation" required/>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-center">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="buttonDisabled">
                    Enregistrer
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
