<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: Array<any>;
    currentPage: number;
    total: number;
    showing: number;
}>();
</script>

<template>
    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            Mostrando {{ showing }} de {{ total }} colaboradores
        </div>
        <div class="flex space-x-2">
            <Link
                v-for="link in links"
                :key="link.url"
                :href="link.url || '#'"
                :class="[
                    'px-3 py-1 rounded-lg border transition-colors',
                    link.active
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                ]"
                v-html="link.label"
            />
        </div>
    </div>
</template>