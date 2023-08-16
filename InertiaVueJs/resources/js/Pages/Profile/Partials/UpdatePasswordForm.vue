<script setup>
import { Alert } from '@/alert';
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import PasswordField from '@/Components/Forms/PasswordField.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            Alert.success('Votre mot de passe a bien été modifié.');
            form.reset();
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="dark:bg-gray-800 dark:text-white">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-inherit">Mettre à jour le mot de passe</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-inherit">
                Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <Label for="current_password" required>Mot de passe actuel</Label>

                <PasswordField
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                    required
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <Label for="password" required>Nouveau mot de passe</Label>

                <PasswordField
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    required
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <Label for="password_confirmation" required>Confirmez le mot de passe</Label>

                <PasswordField
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    required
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Enregistrer</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Enregistré.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
