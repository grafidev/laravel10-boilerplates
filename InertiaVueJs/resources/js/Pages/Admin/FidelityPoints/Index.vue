<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DashboardBreadcrumb from '@/Components/DashboardBreadcrumb.vue';
import Create from './Create.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Table.vue';

import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Drawer from '@/Components/Drawer.vue';
import Label from '@/Components/Forms/Label.vue';
import TextField from '@/Components/Forms/TextField.vue';
import InputError from '@/Components/InputError.vue';
import { Alert } from '@/alert';
import BreadcrumbItem from '@/Components/BreadcrumbItem.vue';

const { auth } = usePage().props;

const showCreate = ref(false);
const configureEarnedPoints = ref(false);

const props = defineProps({ 
    fidelityPoints: Object, 
    fidelityPointsSettings: Object,
    perpage: [String, Number],
    filters: Object,
});

const form = useForm({
    minimal_amount: props.fidelityPointsSettings?.minimal_amount,
    earned_points: props.fidelityPointsSettings?.earned_points,
});

const onConfigureEarnedPoints = () => {
    form.put(route('dashboard.fidelity_points.configureEarnedPoints'), {
        onSuccess() {
            configureEarnedPoints.value = false;
            form.reset();
            Alert.success('Configuration effectuée avec succès.');
        },
    });
};
</script>

<template>
    <DashboardLayout title="Points de fidélité">
        <template #header>
            <DashboardBreadcrumb title="Points de fidélité">
                <BreadcrumbItem :url="route('dashboard.fidelity_points.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-5 h-5 fill-current mr-2.5">
                        <path d="m524-262 140-140q11-11 16-24.5t5-28.5q0-32-22.5-54.5T608-532q-20 0-40 13t-44 42q-24-29-44-42t-40-13q-32 0-54.5 22.5T363-455q0 15 5 28.5t16 24.5l140 140Zm35 165q-18 18-43.5 18T472-97L97-472q-10-10-13.5-21T80-516v-304q0-26 17-43t43-17h304q12 0 24 3.5t22 13.5l373 373q19 19 19 44.5T863-401L559-97Zm-41-41 304-304-378-378H140v304l378 378ZM245-664q21 0 36.5-15.5T297-716q0-21-15.5-36.5T245-768q-21 0-36.5 15.5T193-716q0 21 15.5 36.5T245-664ZM140-820Z"/>
                    </svg>
                    Points de fidélité
                </BreadcrumbItem>
                <BreadcrumbItem>Liste</BreadcrumbItem>
            </DashboardBreadcrumb>
        </template>

        <template #actions>
            <ButtonGroup>
                <SecondaryButton @click.prevent="configureEarnedPoints = true">Configurer gain point de fidélité</SecondaryButton>
                <PrimaryButton @click.prevent="showCreate = true">Créer</PrimaryButton>
            </ButtonGroup>
        </template>

        <Drawer id="configureEarnedPoints" :show="configureEarnedPoints" @close="configureEarnedPoints = false">
            <template #title>
                <h1>Configuration de points de fidélité</h1>
            </template>

            <form @submit.prevent="onConfigureEarnedPoints">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <Label for="minimal_amount" required>Montant minimal</Label>
                        <TextField type="number" id="minimal_amount" v-model="form.minimal_amount" required />
                        <InputError class="mt-2" :message="form.errors.minimal_amount" />
                    </div>

                    <div>
                        <Label for="earned_points" required>Points gagnés</Label>
                        <TextField type="number" id="earned_points" v-model="form.earned_points" required />
                        <InputError class="mt-2" :message="form.errors.earned_points" />
                    </div>

                    <div class="col-span-full">
                        <PrimaryButton class="w-full">Enregistrer</PrimaryButton>
                    </div>
                </div>
            </form>
        </Drawer> 

        <Create :show="showCreate" @close="showCreate = false" />
        
        <Table :filters="props.filters" :perpage="perpage" :fidelity-points="props.fidelityPoints" />
    </DashboardLayout>    
</template>