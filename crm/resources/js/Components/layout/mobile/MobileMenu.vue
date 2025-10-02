<!-- MobileMenu.vue (versão corrigida) -->
<script setup lang="ts">
defineProps<{
    show: boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();
</script>

<template>
    <div v-if="show" class="sm:hidden">
        <div 
            class="fixed inset-0 bg-black/50 z-40"
            @click="emit('close')"
        ></div>
        
        <div class="fixed top-16 left-0 right-0 bg-white shadow-lg z-50 border-t border-gray-200">
            <div class="px-4 py-2">
                <a href="/dashboard" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-md">
                    Dashboard
                </a>
                <a href="/colaboradores" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-md">
                    Colaboradores
                </a>
            </div>
        </div>
    </div>
</template>