<script setup>
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import TextareaField from '@/Components/Forms/TextareaField.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed } from 'vue';
import MultipleCheckInput from '@/Components/Forms/MultipleCheckInput.vue';
import { useSearch } from '@/composables';

const props = defineProps({
    permissions: Array,
    form: Object,
    role: { type: Object, required: false },
});

const allSelected = computed(() => props.form.permissions.length === loadedPermissions.value.length);

const [searchPermissionTerm, loadedPermissions, permissionIds] = useSearch({
    items: props.permissions,
    field: 'description',
    valueKey: 'id',
});

const selectAllPermissions = () => props.form.permissions = permissionIds;
const unSelectAllPermissions = () => props.form.permissions = [];
</script>

<template>
    <div class="grid grid-cols-2 gap-5">
        <div class="col-span-2">
            <Label for="name" required>Nom</Label>
            <TextField type="text" name="name" id="name" v-model="form.name" :disabled="props?.role?.id" required />
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div class="col-span-2">
            <Label for="description" required>Description</Label>
            <TextareaField name="description" id="description" v-model="form.description" required />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="col-span-2" v-if="props.role?.name != 'CLIENT'">
            <Label for="roles">Permission(s)</Label>
            <div class="bg-white col-span-2 py-2  sticky top-0 z-20 dark:bg-gray-800">
                <SearchField v-model="searchPermissionTerm" placeholder="Rechercher" class="w-full"/>
                <div class="col-span-2 mt-2">
                    <a href="#" v-if="allSelected" class="link underline" @click.prevent="unSelectAllPermissions">Tout désélectionner</a>
                    <a href="#" v-else class="link underline" @click.prevent="selectAllPermissions">Tout sélectionner</a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 py-0">
                <MultipleCheckInput
                    v-for="permission in loadedPermissions"
                    :key="permission.id"
                    :id="permission.id"
                    :value="permission.id"
                    v-model="form.permissions"
                >
                    {{ permission.description }}
                </MultipleCheckInput>
            </div>
        </div>

        <div class="col-span-2">
            <PrimaryButton type="submit" :disabled="props.form.processing">Enregistrer</PrimaryButton>
        </div>
    </div>
</template>