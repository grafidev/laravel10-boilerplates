<script setup>
import QrCode from '@/Components/QrCode.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
import { formatNumber } from '@/utils';
const props = defineProps({
    client: Object,
    wallet: Object,
});
</script>

<template>
    <div class="text-center space-y-3">
        <h3 class="text-2xl font-extrabold">
            <NumberFormatter :value="wallet.balance" currency="XOF" />
        </h3>
        
        <div style="padding-inline: 100px;" class="border border-green-500 py-5 max-w-lg inline-flex flex-col space-y-2 items-center bg-green-100 dark:bg-green-800 rounded-lg">
            <QrCode :width="250" :height="200" :id="props.wallet.id" :text="props.wallet.account_number"/>
            <span class="font-bold">{{ wallet.number }}</span>
        </div>
    </div>
</template>