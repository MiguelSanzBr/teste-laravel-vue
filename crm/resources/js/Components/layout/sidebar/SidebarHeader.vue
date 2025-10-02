<script setup lang="ts">
import ApplicationLogo from '@/Components/ui/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    isCollapsed: boolean;
}>();

const emit = defineEmits<{
    toggle: [];
}>();
</script>

<template>
    <div class="flex shrink-0 items-center justify-between px-5 py-5">
        <Link 
            :href="route('dashboard')" 
            class="flex items-center transition-all duration-500"
            :class="isCollapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'"
        >
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-50 rounded-xl shadow-sm">
                    <ApplicationLogo
                        class="block h-6 w-auto fill-current text-blue-600"
                    />
                </div>
                <span class="text-lg font-bold text-gray-800 whitespace-nowrap">Dashboard</span>
            </div>
        </Link>
        
        <button
            @click="emit('toggle')"
            class="p-2.5 rounded-xl transition-all duration-300 hover:bg-white hover:shadow-md border border-transparent hover:border-gray-200"
            :class="isCollapsed ? 'ml-0' : ''"
        >
            <svg 
                class="w-4 h-4 text-gray-500 transition-transform duration-500"
                :class="isCollapsed ? 'rotate-180' : ''"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>
</template>