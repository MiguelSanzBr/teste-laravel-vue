<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    isCollapsed: boolean;
    showingUserDropdown: boolean;
}>();

const emit = defineEmits<{
    'toggle-user-dropdown': [];
    'close-user-dropdown': [];
}>();

// Interface local para o usuário
interface AppUser {
    rsl?: string;
}

const getUserInitial = () => {
    const user = usePage().props.auth?.user as AppUser | undefined;
    
    if (user?.rsl) {
        const words = user.rsl.trim().split(/\s+/);
        if (words[0].toLowerCase() === 'empresa' && words[1]?.toLowerCase() === 'teste') {
            return 'T';
        }
        return words[0].charAt(0).toUpperCase();
    }
    return 'U';
};

// Helper para obter o nome do usuário com tipo seguro
const getUserName = () => {
    const user = usePage().props.auth?.user as AppUser | undefined;
    return user?.rsl || 'Razão Social';
};
</script>

<template>
    <div 
        class="flex shrink-0 p-4 relative" 
        v-if="$page.props.auth.user"
    >
        <button 
            @click="emit('toggle-user-dropdown')"
            class="flex w-full items-center rounded-xl px-3 py-3 text-left transition-all duration-300 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200 group"
        >
            <div class="flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                <span class="text-sm font-semibold text-white px-2 py-1.5">
                    {{ getUserInitial() }}
                </span>
            </div>
            <div 
                class="flex-1 min-w-0 ml-3 transition-all duration-500"
                :class="isCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'"
            >
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ getUserName() }}
                </p>
            </div>
            <svg 
                class="h-4 w-4 text-gray-400 transition-all duration-500 flex-shrink-0 transform group-hover:text-gray-600"
                :class="[
                    isCollapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto',
                    showingUserDropdown ? 'rotate-180' : ''
                ]"
                fill="currentColor" 
                viewBox="0 0 20 20"
            >
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div 
            v-show="showingUserDropdown"
            class="absolute bottom-full left-3 right-3 mb-3 bg-white rounded-xl shadow-xl border border-gray-200 z-50 backdrop-blur-sm bg-opacity-95"
        >
            <div class="py-2">
                <Link 
                    :href="route('profile.edit')" 
                    class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 rounded-lg mx-2"
                    @click="emit('close-user-dropdown')"
                >
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="font-medium">Perfil</span>
                </Link>
                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button"
                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-300 rounded-lg mx-2"
                    @click="emit('close-user-dropdown')"
                >
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="font-medium">Sair</span>
                </Link>
            </div>
            
            <!-- Seta do dropdown -->
            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-white border-r border-b border-gray-200 rotate-45"></div>
        </div>
    </div>
</template>