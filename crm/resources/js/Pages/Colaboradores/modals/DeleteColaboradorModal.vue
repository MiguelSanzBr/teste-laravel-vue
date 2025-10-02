<script setup lang="ts">
import BaseModal from './BaseModal.vue';

interface Colaborador {
    id: number;
    nome: string;
}

defineProps<{
    show: boolean;
    colaborador: Colaborador;
}>();

defineEmits<{
    close: [];
    confirm: [];
}>();
</script>

<template>
    <BaseModal
        :show="show"
        title="Excluir Colaborador"
        @close="$emit('close')"
    >
        <div class="text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Excluir Colaborador</h3>
            <p class="text-sm text-gray-500 mb-6">
                Tem certeza que deseja excluir o colaborador <strong>{{ colaborador.nome }}</strong>? 
                Esta ação não pode ser desfeita.
            </p>

            <div class="flex justify-center space-x-3">
                <button
                    @click="$emit('close')"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium transition-colors"
                >
                    Cancelar
                </button>
                <button
                    @click="$emit('confirm')"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium transition-colors"
                >
                    Excluir
                </button>
            </div>
        </div>
    </BaseModal>
</template>