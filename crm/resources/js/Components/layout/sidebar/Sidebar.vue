<script setup lang="ts">
import SidebarHeader from './SidebarHeader.vue';
import SidebarNavigation from './SidebarNavigation.vue';
import SidebarUserMenu from './SidebarUserMenu.vue';

defineProps<{
    isCollapsed: boolean;
    showingUserDropdown: boolean;
}>();

const emit = defineEmits<{
    toggle: [];
    'toggle-user-dropdown': [];
    'close-user-dropdown': [];
}>();
</script>

<template>
    <nav 
        class="hidden sm:flex sm:flex-col sm:fixed sm:inset-y-0 transition-all duration-500 ease-in-out shadow-2xl"
        :class="isCollapsed ? 'sm:w-20' : 'sm:w-72'"
    >
        <div class="flex flex-grow flex-col overflow-y-auto border-r border-gray-100 bg-white backdrop-blur-sm bg-opacity-95">
            <!-- Header com gradiente sutil -->
            <div class="bg-gradient-to-br from-white to-gray-50 border-b border-gray-100">
                <SidebarHeader 
                    :is-collapsed="isCollapsed"
                    @toggle="emit('toggle')"
                />
            </div>
            
            <!-- Área de navegação com padding ajustado -->
            <div class="flex-1 px-3 py-6">
                <SidebarNavigation :is-collapsed="isCollapsed" />
            </div>
            
            <!-- User menu com fundo sutil -->
            <div class="bg-gray-50 border-t border-gray-100">
                <SidebarUserMenu
                    :is-collapsed="isCollapsed"
                    :showing-user-dropdown="showingUserDropdown"
                    @toggle-user-dropdown="emit('toggle-user-dropdown')"
                    @close-user-dropdown="emit('close-user-dropdown')"
                />
            </div>
        </div>

        <!-- Efeito de brilho na borda -->
        <div class="absolute inset-y-0 right-0 w-px bg-gradient-to-b from-transparent via-gray-200 to-transparent opacity-50"></div>
    </nav>
</template>