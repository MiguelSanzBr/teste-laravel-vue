<script setup lang="ts">
import { onMounted, onUnmounted, watch } from 'vue';

interface Props {
    show: boolean;
    title: string;
    maxWidth?: string;
    closeOnBackdrop?: boolean;
    showCloseButton?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    closeOnBackdrop: true,
    showCloseButton: true,
    maxWidth: 'max-w-md'
});

const emit = defineEmits<{
    close: [];
}>();

// Fechar modal com tecla ESC
const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Escape') {
        emit('close');
    }
};


onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = '';
});

</script>

<template>
    <transition
        enter-active-class="transition-opacity duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div 
            v-if="show" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-hidden"
        >
            <!-- Backdrop com blur -->
            <div 
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                @click="closeOnBackdrop && $emit('close')"
            />
            
            <!-- Container do modal com centralização absoluta -->
            <div class="relative w-full h-full flex items-center justify-center">
                <!-- Modal content -->
                <transition
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition-all duration-200 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div 
                        class="bg-white rounded-2xl shadow-2xl w-full overflow-hidden border border-white/20 transform"
                        :class="[
                            maxWidth,
                            'max-h-[min(90vh,600px)]', // Limita a altura máxima
                            'mx-auto my-auto' // Centralização garantida
                        ]"
                        style="position: relative;"
                    >
                        <!-- Header gradient -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <!-- Ícone decorativo -->
                                    <div class="flex items-center justify-center w-8 h-8 bg-white/20 rounded-lg">
                                        <slot name="icon">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </slot>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ title }}
                                    </h3>
                                </div>
                                
                                <button 
                                    v-if="showCloseButton"
                                    @click="$emit('close')"
                                    class="flex items-center justify-center w-8 h-8 text-white/80 hover:text-white hover:bg-white/20 rounded-lg transition-all duration-200 group"
                                >
                                    <svg class="w-5 h-5 transform group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content area com altura dinâmica -->
                        <div class="overflow-y-auto" :class="{
                            'max-h-[calc(min(90vh,600px)-80px)]': !$slots.footer,
                            'max-h-[calc(min(90vh,600px)-140px)]': $slots.footer
                        }">
                            <div class="p-6">
                                <slot />
                            </div>
                        </div>

                        <!-- Footer slot (opcional) -->
                        <div v-if="$slots.footer" class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                            <slot name="footer" />
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<style scoped>
/* Scrollbar personalizada */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Garantir centralização perfeita */
.fixed.inset-0.flex.items-center.justify-center {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.relative.w-full.h-full.flex.items-center.justify-center {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>