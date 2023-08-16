<script setup>
import SearchField from '@/Components/Forms/SearchField.vue';
import { computed, ref, watch } from 'vue';
import Table from '@/Components/Table/Table.vue';
import Thead from '@/Components/Table/Thead.vue';
import Tbody from '@/Components/Table/Tbody.vue';
import Tr from '@/Components/Table/Tr.vue';
import Th from '@/Components/Table/Th.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from '@/Components/Pagination.vue';
import NoRecords from '@/Components/NoRecords.vue';
import ActiveIcon from '@/Components/ActiveIcon.vue';
import DateForHumans from '@/Components/DateForHumans.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SortableLink from '@/Components/Table/SortableLink.vue';
import Modal from '@/Components/Modal.vue';
import CheckInput from '@/Components/Forms/CheckInput.vue';
import BulkActions from '@/Components/BulkActions.vue';
import { changePerPage } from '@/utils';
import { router, usePage } from '@inertiajs/vue3';
import { Alert } from '@/alert';
import { useCheckAll } from '@/composables';
import BulkAttachmentsForm from './BulkAttachmentsForm.vue';
import PhysicalCardQrCode from './PhysicalCardQrCode.vue';
import ModalContent from '@/Components/ModalContent.vue';
import UserDetails from '../Clients/UserDetails.vue';
import SearchWrapper from '@/Components/SearchWrapper.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DeactivatePhysicalCardForm from './DeactivatePhysicalCardForm.vue';

const props = defineProps({
    physical_cards: Object,
    filters: Object,
    perpage: [String, Number],
});

const search = ref(props.filters.search);
const showingUserDetails = ref(null);
const showingRequestingUserDetails = ref(null);
const showQrCode = ref(null);
const createBulkAttachments = ref(false);
const showDeactivateModal = ref(null);

const { selected, checkAll, onSelectRow } = useCheckAll(props.physical_cards.data);

const onChangePerpage = (perpage) => changePerPage(perpage, route('dashboard.physical_cards.index'));

const deletePhysicalCard = (id) => {
    Alert.confirm("Vous êtes sûr.e?", result => {
        if(result.isConfirmed) {
            router.delete(route('dashboard.physical_cards.destroy', { id }));
        }
    })
}

const activatePhysicalCard = (id) => {
    Alert.confirm("Vous êtes sûr.e?", result => {
        if(result.isConfirmed) {
            router.put(route('dashboard.physical_cards.activate', { id }));
        }
    })
}

const onHandleBulkAction = ({ id }) => {
    createBulkAttachments.value = id === 'attach';
};

const bulkActions = [
    { label: 'Attacher', id: 'attach' },
];

watch(search, (value) => {
    router.get(route('dashboard.physical_cards.index'), { search: value }, { preserveState: true, replace: true });
});

const selectedPhysicardCards = computed(() => props.physical_cards.data.filter(physicalCard => selected.value.includes(physicalCard.id) && physicalCard.needs_attachment));

const onDeactivatePhysicalCard = physicalCard => {

};
</script>

<template>
    <SearchWrapper>
        <template #start>
            <BulkActions v-if="selected.length" :actions="bulkActions" @handle="onHandleBulkAction"/>
        </template>
        <template #end>
            <SearchField v-model="search" placeholder="Rechercher une carte" class="ml-auto" />
            <BulkAttachmentsForm :selected="selectedPhysicardCards" :show="createBulkAttachments" @close="createBulkAttachments = false" />
        </template>
    </SearchWrapper>

    <Table>
        <Thead v-if="props.physical_cards.data.length">
            <Tr>
                <Th><CheckInput v-model="checkAll" /></Th>
                <Th><SortableLink label="Numéro de série" attribute="serial_number" /></Th>
                <Th><SortableLink label="Compte" attribute="user.name" /></Th>
                <Th><SortableLink label="Demandeur (gérant)" attribute="requesting_user.name" /></Th>
                <Th><SortableLink label="Date de demande" attribute="needs_attachment_at" /></Th>
                <Th><SortableLink label="Etat" attribute="active" /></Th>
                <Th><SortableLink label="Activée le" attribute="activated_at" /></Th>
                <Th><SortableLink label="Désactivée le" attribute="deactivated_at" /></Th>
                <Th><SortableLink label="Désactivée par" attribute="deactivated_by" /></Th>
                <Th><SortableLink label="Date de création" attribute="created_at" /></Th>
                <Th>Actions</Th>
            </Tr> 
        </Thead>

        <Tbody>
            <NoRecords title="Aucune carte n'a été enregistrée" v-if="props.physical_cards.data == 0"/>

            <Tr v-for="physical_card in props.physical_cards.data" :key="physical_card.id">
                <Td>
                    <CheckInput
                        :value="physical_card.id"
                        :checked="selected.includes(physical_card.id)" 
                        @change="onSelectRow(physical_card.id, $event.target.checked)" 
                    />
                </Td>
                <Td>{{ physical_card.serial_number }}</Td>
                <Td>
                    <div v-if="physical_card.user">
                        <a href="#" @click.prevent="showingUserDetails = physical_card.user.id" class="text-green-500 underline">{{ physical_card.user.name }}</a>   
                        <Modal :show="showingUserDetails == physical_card.user?.id" @close="showingUserDetails = null">
                            <ModalContent :title="`À propos de ${physical_card.user.name}`" @close="showingUserDetails = null">
                                <UserDetails :user="physical_card.user" />
                            </ModalContent>
                        </Modal>
                    </div>
                    <span v-else>---</span>
                </Td>
                <Td>
                    <div v-if="physical_card.requesting_user">
                        <a href="#" @click.prevent="showingUserDetails = physical_card.requesting_user.id" class="text-green-500 underline">{{ physical_card.requesting_user.name }}</a>   
                        <Modal :show="showingRequestingUserDetails == physical_card.requesting_user?.id" @close="showingRequestingUserDetails = null">
                            <ModalContent :title="`À propos de ${physical_card.requesting_user.name}`" @close="showingRequestingUserDetails = null">
                                <UserDetails :user="physical_card.requesting_user" />
                            </ModalContent>
                        </Modal>
                    </div>
                    <span v-else>---</span>
                </Td>
                <Td><DateForHumans :date="physical_card.needs_attachment_at"/></Td>
                <Td><ActiveIcon :active="physical_card.active" /></Td>
                <Td><DateForHumans :date="physical_card.activated_at"/></Td>
                <Td><DateForHumans :date="physical_card.deactivated_at"/></Td>
                <Td>{{ physical_card.deactivated_by_user?.name || '---' }}</Td>
                <Td><DateForHumans :date="physical_card.created_at"/></Td>
                <Td>
                    <ButtonGroup>
                        <SecondaryButton @click.prevent="showQrCode = physical_card.id">Voir carte</SecondaryButton>
                        <SecondaryButton v-if="physical_card.active" @click.prevent="showDeactivateModal = physical_card.id">Désactiver</SecondaryButton>
                        <PrimaryButton @click.prevent="activatePhysicalCard(physical_card.id)" :disabled="!physical_card.needs_attachment">Attacher</PrimaryButton>
                        <DangerButton @click.prevent="deletePhysicalCard(physical_card.id)">Supprimer</DangerButton>
                        <PhysicalCardQrCode :show="showQrCode == physical_card.id" @close="showQrCode = null" :physical_card="physical_card" />
                        <DeactivatePhysicalCardForm :show="showDeactivateModal == physical_card.id" @close="showDeactivateModal = null" :physical_card="physical_card"/>
                    </ButtonGroup>
                </Td>
            </Tr>
        </Tbody>
    </Table>

    <Pagination :meta="props.physical_cards.meta" :perpage="props.perpage" @on-change-table-records-per-page="onChangePerpage" :links="props.physical_cards.meta.links" />
</template>