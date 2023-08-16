<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DashboardSearchField from '@/Components/DashboardSearchField.vue';
import { Link, usePage } from "@inertiajs/vue3";
import { initDropdowns } from "flowbite";
import { onMounted } from "vue";
import DateForHumans from "@/Components/DateForHumans.vue";
import { router } from "@inertiajs/vue3";
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import SidebarToggler from '@/Components/SidebarToggler.vue'
import { ArrowLeftOnRectangleIcon, BellIcon, ChartPieIcon, Cog8ToothIcon, HomeIcon, UserCircleIcon, UserGroupIcon } from '@heroicons/vue/24/outline';
import Keyboard from '@/Components/Keyboard.vue';
import CountryImage from '@/Components/CountryImage.vue';
import { useRole } from "@/composables";
import UserNav from "./UserNav.vue";
import SpotlightHotKey from "./SpotlightHotKey.vue";
const { auth } = usePage().props;
const { isSuperAdmin, isAdmin } = useRole();
onMounted(() => {
  initDropdowns();
});

const readAll = () => router.post(route('dashboard.notifications.readAll'), {}, {
  onSuccess: () => window.location.reload(),
});
</script>

<template>
  <nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button
            id="toggleSidebarMobile"
            aria-expanded="true"
            aria-controls="sidebar"
            class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            <svg
              id="toggleSidebarMobileHamburger"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <svg
              id="toggleSidebarMobileClose"
              class="hidden w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>

          <div class="flex items-center w-72">
            <SidebarToggler />
            <ApplicationLogo class="text-green-500"/>
          </div>

          <DashboardSearchField v-if="isAdmin()" class="mr-3"/>
          <SpotlightHotKey />
        </div>
        <div class="flex items-center">
          <div class="hidden mr-3 -mb-1 sm:block">
            <span></span>
          </div>

          <button
            id="toggleSidebarMobileSearch"
            type="button"
            class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            <span class="sr-only">Search</span>

            <svg
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>

          <button
            type="button"
            data-dropdown-toggle="notification-dropdown"
            :class="{'text-red-500 hover:text-red-600': auth.unreadNotifications.length}"
            class="p-2 text-gray-500 rounded-lg hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 relative"
          >
            <span class="sr-only">View notifications</span>
            <span class="absolute -top-1 -right-0" v-if="auth.unreadNotifications.length">{{
              auth.unreadNotifications.length
            }}</span>
            <BellIcon class="w-6 h-6"/>
          </button>

          <div
            class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700"
            id="notification-dropdown"
            style="
              position: absolute;
              inset: 0px auto auto 0px;
              margin: 0px;
              transform: translate3d(845px, 62px, 0px);
            "
            data-popper-placement="bottom"
          >
            <div
              class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              Notifications
            </div>
            <div>
              <Link
                :key="notification.id"
                v-for="notification in auth.unreadNotifications"
                href=""
                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600"
              >
                <div class="flex-shrink-0">
                  <img
                    class="rounded-full w-11 h-11"
                    :src="auth.user.profile_photo_url"
                    :alt="auth.user.name"
                  />
                </div>
                <div class="w-full pl-3">
                  <div
                    class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400"
                  >
                    {{ notification.data.comment }}
                  </div>
                  <div
                    class="text-xs font-medium text-primary-700 dark:text-primary-400"
                  >
                    <DateForHumans :date="notification.created_at" :relative="true" />
                  </div>
                </div>
              </Link>
            </div>
            <a
              href="#"
              v-if="auth.unreadNotifications.length"
              @click.prevent="readAll"
              class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline"
            >
              <div class="inline-flex items-center">
                <svg
                  class="w-5 h-5 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                  <path
                    fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <span>Marquer tout comme lu</span>
              </div>
            </a>
          </div>

          <button
            type="button"
            data-dropdown-toggle="apps-dropdown"
            class="hidden p-2 text-gray-500 rounded-lg sm:flex hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700"
          >
            <span class="sr-only">View notifications</span>

            <svg
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
              ></path>
            </svg>
          </button>

          <div
            class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:bg-gray-800 dark:divide-gray-600 border dark:border-gray-700"
            id="apps-dropdown"
            style="
              position: absolute;
              inset: 0px auto auto 0px;
              margin: 0px;
              transform: translate3d(885px, 62px, 0px);
            "
            data-popper-placement="bottom"
          >
            <div
              class="block px-4 py-2 text-base font-medium text-center text-green-700 bg-green-50 dark:bg-green-900/60 dark:text-white"
            >
              Accès rapide
            </div>
            <div class="grid grid-cols-3 gap-4 p-4">
              <Link
                :href="route('dashboard')"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
              >
                <HomeIcon class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"/>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                  Accueil
                </div>
              </Link>

              <Link
                :href="route('profile.edit')"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
              >
                <UserCircleIcon class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" />
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                  Mon profil
                </div>
              </Link>

              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
              >
                <ArrowLeftOnRectangleIcon class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"/>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                  Déconnexion
                </div>
              </Link>
            </div>
          </div>

          <ThemeSwitcher />

          <div class="flex items-center ml-3">
            <div>
              <button
                type="button"
                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button-2"
                aria-expanded="false"
                data-dropdown-toggle="dropdown-2"
              >
                <span class="sr-only">Open user menu</span>
                <img
                  class="w-8 h-8 rounded-full"
                  :src="auth.user.profile_photo_url"
                  :alt="`Avatar de ${auth.user.name}`"
                  :title="`Avatar de ${auth.user.name}`"
                />
              </button>
            </div>

            <UserNav />
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

