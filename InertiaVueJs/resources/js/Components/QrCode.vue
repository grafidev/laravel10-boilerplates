<script setup>
import { ArrowDownTrayIcon, PrinterIcon } from '@heroicons/vue/24/outline';
import { downloadQrCode } from '@/utils';
import VueQrcode from 'vue-qrcode';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import { printQrcode } from '@/composables';

const props = defineProps({
    id: [String, Number],
    text: String,
    width: { type: Number, default: 100 },
    height: { type: Number, default: 100 },
    download: { type: Boolean, default: false },
    print: { type: Boolean, default: false },
    scale: { type: Number, default: 3 },
});

const onPrintQrCode = (id) => {
    printQrcode({ id });
};
</script>
<template>
    <div :class="[
        props.download ? 'pt-2' : '',
        'relative flex items-center justify-center flex-col space-y-2'
    ]" class="relative flex items-center justify-center flex-col space-y-2">
        <div :id="props.id">
            <vue-qrcode
                type="image/png"
                :value="props.text"
                :scale="props.scale"
                :margin="1"
                :color="{ dark: '#000000ff', light: '#ffffffff' }"
            />
        </div>

        <div class="flex items-center gap-2">
            <PrimaryButton v-if="props.download" @click.prevent="downloadQrCode(props.id)">
                <ArrowDownTrayIcon class="w-5 h-5" />
            </PrimaryButton>
            <SecondaryButton v-if="props.print" @click.prevent="onPrintQrCode(props.id)">
                <PrinterIcon class="w-5 h-5" />
            </SecondaryButton>
        </div>
    </div>
</template>