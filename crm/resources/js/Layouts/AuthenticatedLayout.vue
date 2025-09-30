<script setup lang="ts">
import { ref } from 'vue';
import Sidebar from './Sidebar/Sidebar.vue';
import MobileNavbar from './Mobile/MobileNavbar.vue';
import MobileMenu from './Mobile/MobileMenu.vue';

const showingNavigationDropdown = ref(false);
const isSidebarCollapsed = ref(false);
const showingUserDropdown = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const toggleUserDropdown = () => {
    showingUserDropdown.value = !showingUserDropdown.value;
};

const closeUserDropdown = () => {
    showingUserDropdown.value = false;
};

const toggleMobileMenu = () => {
    showingNavigationDropdown.value = !showingNavigationDropdown.value;
};
</script>

<template>
    <div class="flex min-h-screen bg-white">
        <!-- Sidebar -->
        <Sidebar
            :is-collapsed="isSidebarCollapsed"
            :showing-user-dropdown="showingUserDropdown"
            @toggle="toggleSidebar"
            @toggle-user-dropdown="toggleUserDropdown"
            @close-user-dropdown="closeUserDropdown"
        />

        <!-- Main Content -->
        <div 
            class="flex flex-1 flex-col transition-all duration-500 ease-in-out bg-gradient-to-br from-white via-gray-50/30 to-white"
            :class="isSidebarCollapsed ? 'sm:pl-20' : 'sm:pl-72'"
            @click="closeUserDropdown"
        >
            <!-- Mobile Navigation -->
            <MobileNavbar
                :showing-navigation-dropdown="showingNavigationDropdown"
                @toggle-mobile-menu="toggleMobileMenu"
            />

            <MobileMenu :showing-navigation-dropdown="showingNavigationDropdown" />

            <!-- Page Heading -->
            <header
            class="bg-white/80 backdrop-blur-sm border-b border-gray-100/50"
            v-if="$slots.header"
        >
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto text-gray-900">
                    <slot name="header" />
                </div>
            </div>
        </header>

            <!-- Page Content -->
            <main class="flex-1">
                <div class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Container do conteúdo com fundo sutil -->
                        <div class="bg-white/60 rounded-2xl border border-gray-100/50 shadow-sm backdrop-blur-sm">
                            <div class="p-6 sm:p-8">
                                <slot />
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Efeito de brilho sutil no canto -->
            <div class="fixed top-0 right-0 w-1/3 h-1/3 bg-gradient-to-bl from-blue-50/20 to-transparent pointer-events-none -z-10"></div>
        </div>
    </div>
</template>

<style scoped>
/* Efeito de profundidade sutil */
.bg-gradient-to-br {
    background-attachment: fixed;
}

/* Suaviza as transições */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>