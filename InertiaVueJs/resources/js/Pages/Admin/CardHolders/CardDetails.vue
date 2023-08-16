<script setup>
import QrCode from '@/Components/QrCode.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
const props = defineProps({
    client: Object,
    card: Object,
});
</script>

<template>
    <div class="text-center space-y-3">
        <h3 class="text-2xl font-extrabold">
            <NumberFormatter :value="card.balance" currency="XOF" />
        </h3>
        
        <div style="padding-inline: 100px;" class="border border-green-500 py-5 max-w-lg inline-flex flex-col space-y-2 items-center bg-green-100 dark:bg-green-800 rounded-lg">
            <QrCode :scale="5" :id="`card-holder${props.card.id}`" :text="props.card.crypted_number"/>
            <span class="font-bold">{{ props.card.serial_number }}</span>
        </div>
    </div>
</template>