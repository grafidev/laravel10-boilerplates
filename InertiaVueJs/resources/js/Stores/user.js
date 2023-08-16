import { reactive } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { auth } = usePage().props;

export default reactive({
    isAdmin: auth.user.role.name === 'SUPER_ADMIN',
});