<script setup lang="ts">
defineProps<{
    modelValue: string;
    loading?: boolean;
}>();

defineEmits<{
    'update:modelValue': [value: string];
    search: [];
    clear: [];
}>();
</script>

<template>
    <div class="relative">
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <input
                    :value="modelValue"
                    @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
                    type="text"
                    placeholder="Buscar por nome, email ou telefone..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    :class="{
                        'pr-11': modelValue,
                        'bg-gray-50': loading
                    }"
                    :disabled="loading"
                />
                
                <!-- Ícone de busca -->
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <svg 
                        v-if="!loading"
                        class="w-5 h-5 text-gray-400" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <div v-else class="w-5 h-5 flex items-center justify-center">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                    </div>
                </div>

                <!-- Botão de limpar -->
                <button
                    v-if="modelValue && !loading"
                    @click="$emit('clear')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <button
                @click="$emit('search')"
                :disabled="loading"
                class="bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center space-x-2 min-w-[120px] justify-center"
            >
                <span v-if="!loading">Buscar</span>
                <span v-else>Buscando...</span>
            </button>
        </div>
        
        <!-- Contador de resultados -->
        <div v-if="modelValue" class="text-sm text-gray-500 mt-2">
            <span v-if="!loading">Digite para buscar em tempo real</span>
            <span v-else class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-3 w-3 border-b-2 border-blue-500"></div>
                <span>Buscando...</span>
            </span>
        </div>
    </div>
</template>