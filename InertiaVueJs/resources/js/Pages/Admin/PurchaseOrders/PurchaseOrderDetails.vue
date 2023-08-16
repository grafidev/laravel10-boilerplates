<script setup>
import Label from '@/Components/Forms/Label.vue';
import FormCard from '@/Components/FormCard.vue';
import QrCode from '@/Components/QrCode.vue'
import ActiveIcon from '@/Components/ActiveIcon.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import Card from '@/Components/Card.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import CorporateClientInfo from '../Transactions/CorporateClientInfo.vue';
const props = defineProps({
    purchaseOrder: Object,
});
</script>

<template>
    <div class="grid grid-cols-2 gap-2">
        <div class=" text-center">
            <QrCode download print :scale="3" :id="`purchase-order-${props.purchaseOrder.id}`" :text="props.purchaseOrder.crypted_number" />
        </div>
        
        <div class="grid grid-cols-2 gap-4">
        
            <div>
                <Label>Montant</Label>
                <p><NumberFormatter :value="props.purchaseOrder.amount" currency="XOF"/></p>
            </div>
            <div>
                <Label>Etat</Label>
                <div class="flex items-center gap-2">
                    <ActiveIcon :active="props.purchaseOrder.active"/>
                </div>
            </div>
            <div>
                <Label>Numéro de série</Label>
                <div class="flex items-center gap-2">
                    {{ props.purchaseOrder.serial_number }}
                </div>
            </div>
            <div>
                <Label>Date d'utilisation</Label>
                <div class="flex items-center gap-2">
                    <DateForHumans :date="props.purchaseOrder.date_of_use" />
                </div>
            </div>
            <div>
                <Label>Date d'expiration</Label>
                <div class="flex items-center gap-2">
                    <DateForHumans :date="props.purchaseOrder.expiration_date" />
                </div>
            </div>
            <div>
                <Label>Entreprise</Label>
                <CorporateClientInfo :data="props.purchaseOrder.corporate_client" />
            </div>
        </div>
    </div>
</template>