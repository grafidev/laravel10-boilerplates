<script setup>
import SidebarSection from '@/Components/SidebarSection.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { EyeIcon, BanknotesIcon, UsersIcon, BuildingOffice2Icon, DeviceTabletIcon, DocumentTextIcon, UserIcon, UserGroupIcon, KeyIcon, Cog8ToothIcon, BugAntIcon, HomeIcon, ShoppingCartIcon, FunnelIcon, SignalIcon, ArrowDownTrayIcon, ArrowTopRightOnSquareIcon, BellIcon, ChartBarIcon, CreditCardIcon } from '@heroicons/vue/24/outline';
import { useRole } from '@/composables';
const { auth } = usePage().props;
const { isSuperAdmin, isAdmin, isUser } = useRole();

onMounted(() => {
  $('#sidebar li a').click(function(e) {
    const top = $('[scroll-region]').scrollTop();
    localStorage.setItem('latest_sidebar_scrolltop', top);
  });

  const latestScrollTop = localStorage.getItem('latest_sidebar_scrolltop') || 0;
  $('[scroll-region]').scrollTop(latestScrollTop);
});
</script>

<template>
  <aside
    id="sidebar"
    class="dark:[color-scheme:dark] fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-72 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar"
  >
    <div
      class="relative w-full flex flex-col p-0 pl-1 flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto" scroll-region>
        <div
          class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
        >
          <ul class="pb-2 space-y-10">

            <SidebarSection title="Tableau de bord" class="pt-0" v-if="isAdmin()">
              <SidebarLink 
                :active="route().current('dashboard')"
                :href="route('dashboard')" 
                title="Accueil" 
                v-if="auth.permissions.includes('show_dashboard')"
              >
                <template #icon>
                  <HomeIcon class="w-5 h-5"/>
                </template>
              </SidebarLink>
              
            </SidebarSection>

            <SidebarSection title="Gestion des accès et droits">
              <SidebarLink 
                :active="$page.url.includes('/users')"
                :href="route('dashboard.users.index')" 
                title="Comptes utilisateurs" 
                v-if="auth.permissions.includes('list_user')"
              >
                <template #icon>
                  <UserIcon class="w-5 h-5" />
                </template>
              </SidebarLink>
       

              <SidebarLink 
                :active="$page.url.includes('/roles')"
                :href="route('dashboard.roles.index')" 
                title="Roles & permissions" 
                v-if="auth.permissions.includes('list_role')"
              >
                <template #icon>
                  <UserGroupIcon class="w-5 h-5" />
                </template>
              </SidebarLink>
            </SidebarSection>
          </ul>
        </div>
      </div>
    </div>
  </aside>
</template>
