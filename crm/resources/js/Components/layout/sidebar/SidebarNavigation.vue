<script setup lang="ts">
import NavLink from '@/Components/ui/NavLink.vue';

defineProps<{
    isCollapsed: boolean;
}>();
</script>

<template>
    <div class="space-y-3">
        <!-- Dashboard -->
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
            class="group flex items-center rounded-2xl px-2 py-4 text-base font-semibold transition-all duration-500 ease-out"
            :class="{
                'scale-[1.02] transform bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25':
                    route().current('dashboard'),
                'border border-gray-100 text-gray-700 hover:scale-[1.02] hover:transform hover:bg-white hover:text-gray-900 hover:shadow-lg hover:shadow-gray-200/50':
                    !route().current('dashboard'),
            }">
            <div class="flex w-full items-center">
                <div class="flex flex-1 items-center">
                    <div class="relative flex h-8 w-8 flex-shrink-0 items-center justify-center">
                        <svg class="h-5 w-5 flex-shrink-0 transition-all duration-300" :class="route().current('dashboard')
                                ? 'text-white'
                                : 'text-gray-500 group-hover:text-blue-600'
                            " fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>

                        <div v-if="route().current('dashboard')"
                            class="absolute inset-0 scale-125 rounded-full bg-white/30 blur-[2px]"></div>
                    </div>

                    <span class="ml-3 truncate whitespace-nowrap font-medium transition-all duration-300" :class="[
                        isCollapsed
                            ? 'w-0 opacity-0'
                            : 'w-auto opacity-100',
                        route().current('dashboard')
                            ? 'text-white'
                            : 'text-gray-700 group-hover:text-gray-900',
                    ]">
                        Dashboard
                    </span>
                </div>

                <div class="ml-2 flex-shrink-0">
                    <div v-if="route().current('dashboard') && !isCollapsed" class="flex items-center space-x-1">
                        <div class="flex space-x-1">
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/90"></div>
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/70 delay-75"></div>
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/50 delay-150"></div>
                        </div>
                    </div>

                    <div v-else-if="
                        !route().current('dashboard') && !isCollapsed
                    " class="opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                    </div>
                </div>
            </div>
        </NavLink>

        <!-- Colaboradores -->
        <NavLink :href="route('colaboradores.index')" :active="route().current('colaboradores.*')"
            class="group flex items-center rounded-2xl px-2 py-4 text-base font-semibold transition-all duration-500 ease-out"
            :class="{
                'scale-[1.02] transform bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25':
                    route().current('colaboradores.*'),
                'border border-gray-100 text-gray-700 hover:scale-[1.02] hover:transform hover:bg-white hover:text-gray-900 hover:shadow-lg hover:shadow-gray-200/50':
                    !route().current('colaboradores.*'),
            }">
            <div class="flex w-full items-center">
                <div class="flex flex-1 items-center">
                    <div class="relative flex h-8 w-8 flex-shrink-0 items-center justify-center">
                        <svg class="h-5 w-5 flex-shrink-0 transition-all duration-300" :class="route().current('colaboradores.*')
                                ? 'text-white'
                                : 'text-gray-500 group-hover:text-blue-600'
                            " fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>

                        <div v-if="route().current('colaboradores.*')"
                            class="absolute inset-0 scale-125 rounded-full bg-white/30 blur-[2px]"></div>
                    </div>

                    <span class="ml-3 truncate whitespace-nowrap font-medium transition-all duration-300" :class="[
                        isCollapsed
                            ? 'w-0 opacity-0'
                            : 'w-auto opacity-100',
                        route().current('colaboradores.*')
                            ? 'text-white'
                            : 'text-gray-700 group-hover:text-gray-900',
                    ]">
                        Colaboradores
                    </span>
                </div>

                <div class="ml-2 flex-shrink-0">
                    <div v-if="route().current('colaboradores.*') && !isCollapsed" class="flex items-center space-x-1">
                        <div class="flex space-x-1">
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/90"></div>
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/70 delay-75"></div>
                            <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-white/50 delay-150"></div>
                        </div>
                    </div>

                    <div v-else-if="
                        !route().current('colaboradores.*') && !isCollapsed
                    " class="opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                    </div>
                </div>
            </div>
        </NavLink>

        <!-- Efeito de linha sutil entre itens -->
        <div class="mx-4 border-t border-gray-100/50 opacity-0"></div>
    </div>
</template>

<style scoped>
/* Efeito de brilho sutil no hover */
.group:hover .relative>div:first-child {
    filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.3));
}

/* Transição suave para o scale */
.transform {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>