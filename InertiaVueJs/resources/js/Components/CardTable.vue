<script setup>
const props = defineProps({ title: String, description: String })
</script>

<template>
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800" >
        <!-- Card header -->
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3
                    class="mb-2 text-xl font-bold text-gray-900 dark:text-white"
                >
                    {{ title }}
                </h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                    {{ description }}
                </span>
            </div>

            <div class="items-center sm:flex">
                <slot name="actions" />
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto rounded-lg">
                <div
                    class="inline-block min-w-full align-middle"
                >
                    <div
                        class="overflow-hidden shadow sm:rounded-lg"
                    >
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Footer -->
        <div class="flex items-center justify-between pt-3 sm:pt-6" >
            <slot name="footer" />
        </div>
    </div>
</template>