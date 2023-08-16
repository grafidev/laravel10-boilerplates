<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Badge from './Badge.vue';
const { auth } = usePage().props;
</script>

<template>
    <div
        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
        id="dropdown-2"
        style="
            position: absolute;
            inset: 0px auto auto 0px;
            margin: 0px;
            transform: translate3d(973px, 58px, 0px);
        "
        data-popper-placement="bottom"
    >
        <div class="px-4 py-3 text-center" role="none">
            <p class="font-bold uppercase text-sm text-gray-900 dark:text-white" role="none">{{ auth.user.name }}</p>
            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">{{ auth.user.email }}
            </p>
            <div class="flex flex-col items-center space-y-2 pt-1" v-if="auth.user.roles.length">
                <Badge v-for="role in auth.user.roles" :key="role" color="info">{{ role.description }}</Badge>
            </div>
        </div>
        <ul class="py-1" role="none">
            <li>
                <Link
                    :href="route('dashboard')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="dashboard"
                >
                    Tableau de bord
                </Link>
            </li>

            <li>
                <Link
                    :href="route('profile.edit')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="myprofile"
                >
                    Mon compte
                </Link>
            </li>

            <li>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="block px-4 w-full text-left py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="logout"
                >
                    Déconnexion
                </Link>
            </li>
        </ul>
    </div>
</template>