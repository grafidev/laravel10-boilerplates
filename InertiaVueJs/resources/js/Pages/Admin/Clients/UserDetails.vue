<script setup>
import Label from '@/Components/Forms/Label.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import CountryImage from '@/Components/CountryImage.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
const props = defineProps({
    user: Object,
    cols: { type: Number, default: 2}
});
</script>

<template>
    <div :class="[`grid-cols-${props.cols}`, 'grid gap-4']">
        <div>
            <Label for="user_name">Nom</Label>   
            <p>{{ props.user.name }}</p>
        </div>

        <div v-if="props.user.email">
            <Label for="email">Adresse email</Label>   
            <p>{{ props.user.email }}</p>
        </div>

        <div>
            <Label for="phone_number">Numéro de téléphone</Label>   
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
            <Label for="country">Pays</Label>   
            <p class="flex items-center gap-2">
                <CountryImage :country="props.user.country" /> <span>{{ props.user.country.name }}</span>
            </p>
        </div>

        <div v-if="props.user.created_at">
            <Label for="created_at">Date de création du compte</Label>   
            <p><DateForHumans :date="props.user.created_at" /></p>
        </div>

        <div v-if="props.user?.station?.name">
            <Label for="station_name">Station</Label>   
            <p>{{ props.user?.station?.name }}</p>
        </div>

        <div>
            <Label for="active">Etat du compte</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="props.user.active"/>
            </p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="wallet_state">Etat du portefeuille</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="!props.user.wallet.is_blocked" />
            </p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="wallet_balance">Solde</Label>   
            <p class="flex items-center gap-2">
                <NumberFormatter :value="props.user.wallet.balance" currency="XOF"/>
            </p>
        </div>

        <div v-if="props.user?.terminalInfo?.brand">
            <Label for="brand">Marque</Label>   
            <p>{{ props.user?.terminalInfo?.brand }}</p>
        </div>

        <div v-if="props.user?.terminalInfo?.model">
            <Label for="model">Modèle</Label>   
            <p>{{ props.user?.terminalInfo?.model }}</p>
        </div>

        <div v-if="props.user?.terminalInfo?.serial_number">
            <Label for="serial_number">Numéro de série</Label>   
            <p>{{ props.user?.terminalInfo?.serial_number }}</p>
        </div>
    </div>
</template>
