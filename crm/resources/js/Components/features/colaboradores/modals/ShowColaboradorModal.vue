<script setup lang="ts">
import BaseModal from './BaseModal.vue';

interface Colaborador {
    id: number;
    nome: string;
    telefone: string;
    email: string;
    created_at: string;
    ativo: boolean;
}

defineProps<{
    show: boolean;
    colaborador: Colaborador;
}>();

defineEmits<{
    close: [];
}>();
</script>

<template>
    <BaseModal
        :show="show"
        title="Detalhes do Colaborador"
        @close="$emit('close')"
    >
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome completo</label>
                <p class="mt-1 text-sm text-gray-900">{{ colaborador.nome }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone</label>
                <p class="mt-1 text-sm text-gray-900">{{ colaborador.telefone }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ colaborador.email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data de Cadastro</label>
                <p class="mt-1 text-sm text-gray-900">{{ colaborador.created_at }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <span
                    :class="[
                        'inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1',
                        colaborador.ativo
                            ? 'bg-green-100 text-green-800'
                            : 'bg-red-100 text-red-800'
                    ]"
                >
                    {{ colaborador.ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
            <button
                @click="$emit('close')"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium transition-colors"
            >
                Fechar
            </button>
        </div>
    </BaseModal>
</template>