<script setup>
import Card from '@/Components/Card.vue';
import FormCard from '@/Components/FormCard.vue';
import Label from '@/Components/Forms/Label.vue';
const props = defineProps({
    corporateClient: Object,
    cols: { type: Number, default: 3 }
});
</script>

<template>
    <div :class="[ `grid-cols-${props.cols}`, 'grid gap-4' ]">
        <div>
            <Label for="name">Nom</Label>   
            <p>{{ props.corporateClient.name }}</p>
        </div>

        <div>
            <Label for="ninea">NINEA</Label>   
            <p>{{ props.corporateClient.ninea }}</p>
        </div>

        <div>
            <Label for="ninea">Adresse email</Label>   
            <p>{{ props.corporateClient.email }}</p>
        </div>

        <div>
            <Label for="ninea">Numéro de téléphone </Label>   
            <p>{{ props.corporateClient.phone_number }}</p>
        </div>

        <div>
            <Label for="ninea">Adresse</Label>   
            <p>{{ props.corporateClient.address }}</p>
        </div>

        <div v-if="props.corporateClient.contact_name">
            <Label for="ninea">Nom du contact</Label>   
            <p>{{ props.corporateClient.contact_name }}</p>
        </div>

        <div v-if="props.corporateClient.contact_email">
            <Label for="ninea">Email du contact</Label>   
            <p>{{ props.corporateClient.contact_email }}</p>
        </div>

        <div v-if="props.corporateClient.contact_phone_number">
            <Label for="contact_phone_number">Numéro de téléphone du contact</Label>   
            <p>{{ props.corporateClient.contact_phone_number }}</p>
        </div>

        <div v-if="props.corporateClient.regime">
            <Label for="regime">Régime</Label>   
            <p>{{ props.corporateClient.regime }}</p>
        </div>

        <div v-if="props.corporateClient.discount">
            <Label for="regime">Remise</Label>   
            <p>{{ props.corporateClient.discount }}</p>
        </div>

        <div v-if="props.corporateClient.currenc">
            <Label for="regime">Devise</Label>   
            <p>{{ props.corporateClient.currency }}</p>
        </div>

        <div v-if="props.corporateClient.periodicity">
            <Label for="periodicity">Périodicité (jours)</Label>   
            <p>{{ props.corporateClient.periodicity }}</p>
        </div>
    </div>
</template>