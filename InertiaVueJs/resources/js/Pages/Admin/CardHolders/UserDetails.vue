<script setup>
import Label from '@/Components/Forms/Label.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import CountryImage from '@/Components/CountryImage.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
const props = defineProps({
    user: Object,
    cols: { type: Number, default: 2}
});
</script>

<template>
    <div :class="[`grid-cols-${props.cols}`, 'grid gap-4']">
        <div>
            <Label for="name">Nom</Label>   
            <p>{{ props.user.name }}</p>
        </div>

        <div v-if="props.user.email">
            <Label for="ninea">Adresse email</Label>   
            <p>{{ props.user.email }}</p>
        </div>

        <div>
            <Label for="ninea">Numéro de téléphone </Label>   
            <p>{{ props.user.phone_number }}</p>
        </div>

        <div v-if="props.user.address">
            <Label for="ninea">Adresse</Label>   
            <p>{{ props.user.address }}</p>
        </div>

        <div v-if="props.user.company">
            <Label for="ninea">Compagnie</Label>   
            <p>{{ props.user.company.name }}</p>
        </div>

        <div v-if="props.user.country">
            <Label for="countryName">Pays</Label>   
            <p class="flex items-center gap-2">
                <CountryImage class="w-5 h-5" :country="props.user.country" /> {{ props.user.country.name }}
            </p>
        </div>

        <div>
            <Label for="active">Etat du compte</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="props.user.active"/>
            </p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="active">Etat du portefeuille</Label>   
            <p class="flex items-center gap-2">
                <ActiveIcon :active="!props.user.wallet.is_blocked" />
            </p>
        </div>

        <div v-if="props.user?.wallet">
            <Label for="active">Solde</Label>   
            <p class="flex items-center gap-2">
                <NumberFormatter :value="props.user.wallet.balance" currency="XOF"/>
            </p>
        </div>
    </div>
</template>
