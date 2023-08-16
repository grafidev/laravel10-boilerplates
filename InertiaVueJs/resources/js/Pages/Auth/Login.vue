a<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Label from '@/Components/Forms/Label.vue'
import TextField from '@/Components/Forms/TextField.vue'
import PasswordField from '@/Components/Forms/PasswordField.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import PhoneInput from '@/Components/Forms/PhoneInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    identifiant_type: 'email',
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout title="Connexion">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
            Se connecter
        </h2>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form class="mt-8 space-y-6" action="#" @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
                <Label class="col-span-full" required>Choisir comment me connecter</Label>
                <RadioField name="identifiant_type" id="email_id" value="email" :chosen-value="form.identifiant_type" @change="value => form.identifiant_type = value">Adresse email</RadioField>
                <RadioField name="identifiant_type" id="phone_number_id" value="phone_number" :chosen-value="form.identifiant_type" @change="value => form.identifiant_type = value">Numéro de téléphone</RadioField>
            </div>

            <div v-if="form.identifiant_type === 'phone_number'">
                <Label for="email">Numéro de téléphone</Label>
                <PhoneInput name="email" id="email" v-model="form.email" required :single-country="false"/>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="form.identifiant_type === 'email'">
                <Label for="email">Adresse email</Label>
                <TextField type="email" name="email" id="email" v-model="form.email" required />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <Label for="password">Mot de passe</Label>
                <PasswordField name="password" id="password" v-model="form.password" required />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Me connecter
                </PrimaryButton>

                <Link 
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="ml-auto text-sm text-primary-700 hover:underline dark:text-white"
                >
                    Mot de passe oublié?
                </Link>
            </div>
        </form>
    </GuestLayout>
    
</template>
