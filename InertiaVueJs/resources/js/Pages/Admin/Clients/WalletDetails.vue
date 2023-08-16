<script setup>
import QrCode from '@/Components/QrCode.vue';
import NumberFormatter from '@/Components/NumberFormatter.vue';
const props = defineProps({
    client: Object,
    wallet: Object,
});
</script>

<template>
    <div class="text-center space-y-3 w-full">
        <h3 class="text-2xl font-extrabold">
            <NumberFormatter :value="wallet.balance" currency="XOF" />
        </h3>
        <div class="border border-green-500 py-5 inline-flex flex-col space-y-2 items-center bg-green-100 dark:bg-green-800 rounded-lg px-20">
            <QrCode :scale="5" :id="`qrcode-client${props.wallet.id}`" :text="props.wallet.crypted_account_number"/>
            <span class="font-bold">{{ wallet.number }}</span>
        </div>
    </div>
</template>