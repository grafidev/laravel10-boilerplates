<script setup>
import { usePage, Link, router } from '@inertiajs/vue3';
import SecondaryButton from '../SecondaryButton.vue';
import { ArrowLeftOnRectangleIcon } from '@heroicons/vue/24/outline';
const { auth } = usePage().props;

const logout = () => router.post(route('logout'));
</script>

<template>
  <div
    class="p-2 space-y-2 border bg-white rounded-xl shadow dark:border-gray-700 dark:bg-gray-800"
  >
    <div class="space-y-2">
      <div class="px-4 py-4 space-y-4">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
          <img
            :src="auth.user.profile_photo_url"
            class="w-10 h-10 rounded-full bg-gray-200 bg-cover bg-center dark:bg-gray-900"
          />

          <div class="space-y-2 flex items-center justify-between w-full">
            <div>
              <div class="flex items-center mb-1">
                <h2 class="text-lg sm:text-xl font-bold tracking-tight dark:text-white">
                  Bonjour {{ auth.user.name }}
                </h2>
              </div>

              <div class="text-xs dark:text-white">
                Role(s):
                <span class="font-bold uppercase">{{ auth.user.roles.map(role => role.description).join(', ') }}</span>
              </div>
            </div>
            <div>
              <SecondaryButton @click.prevent="logout">
                <ArrowLeftOnRectangleIcon class="w-5 h-5 mr-2"/> Déconnexion
              </SecondaryButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>