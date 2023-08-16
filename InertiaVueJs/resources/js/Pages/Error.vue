<script setup>
import { computed } from "vue";
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({ status: Number });

const title = computed(() => {
  return {
    503: "Le service en maintenance",
    500: "Erreur interne",
    404: "Page introuvable",
    403: "Désolé, vous n'avez pas les permissions suffisantes pour effectuer cette action.",
  }[props.status];
});

const description = computed(() => {
  return {
    503: "Désolé, nous faisons de la maintenance. Veuillez revenir bientôt.",
    500: "Oups, quelque chose s'est mal passé sur nos serveurs.",
    404: "Désolé, la page que vous recherchez est introuvable.",
    403: "Désolé, il vous est interdit d'accéder à cette page.",
  }[props.status];
});

const image = computed(() => {
  return {
    503: '/images/errors/503.svg',
    404: '/images/errors/404.svg',
    500: '/images/errors/500.svg',
    403: '/images/errors/403.svg',
  }[props.status];
});
</script>

<template>
  <Head :title="title" />

  <!-- component -->
<!-- MDI Icons -->

<!-- Page Container -->
<div class="flex items-center justify-center min-h-screen bg-white py-38">
    <div class="flex flex-col max-w-4xl">
        <!-- Notes -->
        <span class="text-center font-bold my-10 opacity-30">

            <hr class="my-4">

            <Link :href="route('dashboard')" target="_blank" class="text-red-600">
              Revenir à l'accueil
            </Link>
        </span>

        <!-- Error Container -->
        <div class="flex flex-col items-center">
            <div class="text-red-500 font-bold text-7xl">
                {{ props.status }}
            </div>

            <div class="font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl mt-10 text-center">
              {{ title }}
            </div>

            <div class="text-gray-400 font-medium text-sm md:text-xl lg:text-2xl mt-8">
              {{ description }}
            </div>
        </div>

        <!-- Continue With -->
        <div class="flex flex-col mt-[70px]">
            <div class="text-gray-400 font-bold uppercase">
              Continuer avec
            </div>

            <div class="flex flex-col items-stretch mt-5">
                <!-- Nav Item #1 -->
                <div class="flex flex-row group px-4 py-8
                    border-t hover:cursor-pointer
                    transition-all duration-200 delay-100">

                    <!-- Nav Icon -->
                    <div class="rounded-xl bg-red-100 px-3 py-2 md:py-4">
                        <i class="mdi mdi-home-outline mx-auto 
                            text-gray-900 text-2xl md:text-3xl"></i>
                    </div>

                    <!-- Text -->
                    <Link :href="route('dashboard')" class="grow flex flex-col pl-5 pt-2">
                        <div class="font-bold text-sm md:text-lg lg:text-xl group-hover:underline">
                          Accueil
                        </div>

                        <div class="font-semibold text-sm md:text-md lg:text-lg
                            text-gray-400 group-hover:text-gray-500
                            transition-all duration-200 delay-100">
                            Tout commence ici
                        </div>
                    </Link>

                    <!-- Chevron -->
                    <i class="mdi mdi-chevron-right text-gray-400 mdi-24px my-auto pr-2
                        group-hover:text-gray-700 transition-all duration-200 delay-100"></i>
                </div>

                <!-- Nav Item #2 -->
                <div class="flex flex-row group px-4 py-8
                    border-t hover:cursor-pointer
                    transition-all duration-200 delay-100">

                    <!-- Nav Icon -->
                    <div class="rounded-xl bg-red-100 px-3 py-2 md:py-4">
                        <i class="mdi mdi-book-open-page-variant-outline mx-auto 
                            text-gray-800 text-2xl md:text-3xl"></i>
                    </div>

                    <!-- Text -->
                    <Link :href="route('dashboard.order-requests.index')" class="grow flex flex-col pl-5 pt-2">
                        <div class="font-bold text-sm md:text-lg lg:text-xl group-hover:underline">
                            Commandes
                        </div>

                        <div class="font-semibold text-sm md:text-md lg:text-lg
                            text-gray-400 group-hover:text-gray-500
                            transition-all duration-200 delay-100">
                            Liste des commandes
                        </div>
                    </Link>

                    <!-- Chevron -->
                    <i class="mdi mdi-chevron-right text-gray-400 mdi-24px my-auto pr-2
                        group-hover:text-gray-700 transition-all duration-200 delay-100"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</template>