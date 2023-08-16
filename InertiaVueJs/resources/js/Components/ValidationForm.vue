<script setup>
import Label from '@/Components/Forms/Label.vue';
import RadioField from '@/Components/Forms/RadioField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { notices } from '@/composables'

const props = defineProps({
    url: String,
});

const form = useForm({
    notice: null,
    comment: '',
});

const submit = () => {
    form.post(props.url, {
        onSuccess: () => {
        }
    });
};

</script>

<template>
    <form @submit.prevent="submit" class="space-y-7">
        <div class="col-span-2">
            <Label required>Avis</Label>
            <RadioField 
                v-for="notice in notices.value"
                :key="notice.value" 
                name="notice"
                :id="notice.value" 
                :value="notice.value" 
                @change="value => form.notice = value"
                :chosen-value="form.notice"
                class="mb-4"
            >
                {{ notice.label }}
            </RadioField>

            <InputError class="mt-2" :message="form.errors.notice" />
        </div>

        <div class="col-span-full" v-if="form.notice === 'REJETEE'">
            <Label required for="comment">Commentaire</Label>
            <TextareaField v-model="form.comment" id="comment"/>
            <InputError class="mt-2" :message="form.errors.comment" />
        </div>

        <div class="col-span-full">
            <PrimaryButton type="submit">Valider</PrimaryButton>
        </div>
    </form>
</template>