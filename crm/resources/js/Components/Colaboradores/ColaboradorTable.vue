<script setup lang="ts">
interface Colaborador {
    id: number;
    nome: string;
    telefone: string;
    email: string;
    created_at: string;
    ativo: boolean;
}

defineProps<{
    colaboradores: Colaborador[];
}>();

defineEmits<{
    view: [colaborador: Colaborador];
    edit: [colaborador: Colaborador];
    delete: [colaborador: Colaborador];
}>();
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nome
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Telefone
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data de Cadastro
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr 
                    v-for="colaborador in colaboradores" 
                    :key="colaborador.id"
                    class="hover:bg-gray-50 transition-colors"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ colaborador.nome }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ colaborador.telefone }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ colaborador.email }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ colaborador.created_at }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                colaborador.ativo
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'
                            ]"
                        >
                            {{ colaborador.ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button
                                @click="$emit('view', colaborador)"
                                class="text-blue-600 hover:text-blue-900 transition-colors"
                            >
                                Ver
                            </button>
                            <button
                                @click="$emit('edit', colaborador)"
                                class="text-green-600 hover:text-green-900 transition-colors"
                            >
                                Editar
                            </button>
                            <button
                                @click="$emit('delete', colaborador)"
                                class="text-red-600 hover:text-red-900 transition-colors"
                            >
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>