<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';

defineProps<{
    isCollapsed: boolean;
}>();
</script>

<template>
    <div class="space-y-3">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
            class="group flex items-center rounded-2xl px-2 py-4 text-base font-semibold transition-all duration-500 ease-out"
            :class="{
                'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25 transform scale-[1.02]': route().current('dashboard'),
                'text-gray-700 hover:bg-white hover:text-gray-900 hover:shadow-lg hover:shadow-gray-200/50 hover:transform hover:scale-[1.02] border border-gray-100': !route().current('dashboard')
            }"
        >
            <!-- Ícone com efeito melhorado -->
           <div class="flex items-center w-full">
    <!-- Container do ícone e texto -->
    <div class="flex items-center flex-1">
        <!-- Ícone com alinhamento perfeito -->
        <div class="relative flex-shrink-0 w-8 h-8 flex items-center justify-center">
            <svg class="h-5 w-5 transition-all duration-300 flex-shrink-0" 
                 :class="route().current('dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600'"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            
            <!-- Efeito de brilho sutil -->
            <div v-if="route().current('dashboard')" 
                 class="absolute inset-0 bg-white/30 rounded-full scale-125 blur-[2px]"></div>
        </div>

        <!-- Texto perfeitamente alinhado -->
        <span 
            class="ml-3 transition-all duration-300 whitespace-nowrap truncate font-medium"
            :class="[
                isCollapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto',
                route().current('dashboard') ? 'text-white' : 'text-gray-700 group-hover:text-gray-900'
            ]"
        >
            Dashboard
        </span>
    </div>

    <!-- Indicadores do lado direito -->
    <div class="flex-shrink-0 ml-2">
        <!-- Indicador ativo com design limpo -->
        <div v-if="route().current('dashboard') && !isCollapsed" 
             class="flex items-center space-x-1">
            <div class="flex space-x-1">
                <div class="w-1.5 h-1.5 bg-white/90 rounded-full animate-pulse"></div>
                <div class="w-1.5 h-1.5 bg-white/70 rounded-full animate-pulse delay-75"></div>
                <div class="w-1.5 h-1.5 bg-white/50 rounded-full animate-pulse delay-150"></div>
            </div>
        </div>

        <!-- Indicador hover sutil -->
        <div v-else-if="!route().current('dashboard') && !isCollapsed" 
             class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
        </div>
    </div>
</div>
        </NavLink>

        <!-- Efeito de linha sutil entre itens (para quando tiver mais itens) -->
        <div class="border-t border-gray-100/50 mx-4 opacity-0"></div>
    </div>
</template>

<style scoped>
/* Efeito de brilho sutil no hover */
.group:hover .relative > div:first-child {
    filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.3));
}

/* Transição suave para o scale */
.transform {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>