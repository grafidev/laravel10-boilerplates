<script setup>
import Label from '@/Components/Forms/Label.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import CountryImage from '@/Components/CountryImage.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
const props = defineProps({
    user: Object,
    cols: { type: Number, default: 2 },
});
</script>

<template>
    <div :class="[`grid-cols-${props.cols}`, 'grid gap-4']">
        <div>
            <Label for="name">Nom</Label>   
            <p>{{ props.user.name }}</p>
        </div>

        <div v-if="props.user.email">
            <Label for="email">Adresse email</Label>   
            <p>{{ props.user.email }}</p>
        </div>

        <div>
            <Label for="phone_number">Numéro de téléphone </Label>   
            <p>{{ props.user.phone_number }}</p>
        </div>

        <div v-if="props.user.address">
            <Label for="address">Adresse</Label>   
            <p>{{ props.user.address }}</p>
        </div>

        <div v-if="props.user.company">
            <Label for="company_name">Compagnie</Label>   
            <p>{{ props.user.company.name }}</p>
        </div>

        <div v-if="props.user.country">
            <Label for="user_country">Pays</Label>   
            <p class="flex items-center gap-2">
                <CountryImage :country="props.user.country" /> {{ props.user.country.name }}
            </p>
        </div>

        <div>
            <Label for="active">Etat du compte</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="props.user.active"/>
            </p>
        </div>

        <div>
            <Label for="serial_number">Numéro série carte</Label>   
            <p class="flex items-center gap-2">
                {{ props.user.card.serial_number }}
            </p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="is_balance">Etat du portefeuille</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="!props.user.card.is_blocked" />
            </p>
        </div>

        <div v-if="props.user.vehicle_registration_number">
            <Label for="vehicle_registration_number">Numéro d'immatriculation du véhicule</Label>   
            <p>{{ props.user.vehicle_registration_number }}</p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="card_balance">Solde</Label>   
            <p class="flex items-center gap-2">
                <NumberFormatter :value="props.user.card.balance" currency="XOF" />
            </p>
        </div>
    </div>
</template>
