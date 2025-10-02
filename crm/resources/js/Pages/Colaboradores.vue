<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

import ColaboradorTable from '@/Components/features/colaboradores/components/ColaboradorTable.vue';
import ColaboradorSearch from '@/Components/features/colaboradores/components/ColaboradorSearch.vue';
import ColaboradorPagination from '@/Components/features/colaboradores/components/ColaboradorPagination.vue';
import ColaboradorEmptyState from '@/Components/features/colaboradores/components/ColaboradorEmptyState.vue';
import CreateColaboradorModal from '@/Components/features/colaboradores/modals/CreateColaboradorModal.vue';
import EditColaboradorModal from '@/Components/features/colaboradores/modals/EditColaboradorModal.vue';
import ShowColaboradorModal from '@/Components/features/colaboradores/modals/ShowColaboradorModal.vue';
import DeleteColaboradorModal from '@/Components/features/colaboradores/modals/DeleteColaboradorModal.vue';

interface Colaborador {
    id: number;
    nome: string;
    telefone: string;
    email: string;
    created_at: string;
    ativo: boolean;
}

const props = defineProps<{
    colaboradores: {
        data: Colaborador[];
        links: Array<any>;
        current_page: number;
        total: number;
    };
    filters: {
        search?: string;
    };
}>();

// Estados reativos
const search = ref(props.filters.search || '');
const modalState = ref({
    create: false,
    edit: false,
    show: false,
    delete: false
});
const selectedColaborador = ref<Colaborador | null>(null);
const isLoading = ref(false);

// Forms
const createForm = useForm({
    nome: '',
    telefone: '',
    email: '',
});

const editForm = useForm({
    nome: '',
    telefone: '',
    email: '',
});

// Watch para pesquisa em tempo real com debounce manual
let debounceTimeout: ReturnType<typeof setTimeout> | null = null;
watch(search, (newSearch) => {
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        isLoading.value = true;
        router.get(route('colaboradores.index'), 
            { search: newSearch }, 
            { 
                preserveState: true, 
                replace: true,
                preserveScroll: true,
                onFinish: () => {
                    isLoading.value = false;
                }
            }
        );
    }, 500);
});

// Funções de modal
const openModal = (type: 'create' | 'edit' | 'show' | 'delete', colaborador?: Colaborador) => {
    if (colaborador) {
        selectedColaborador.value = colaborador;
        if (type === 'edit') {
            editForm.nome = colaborador.nome;
            editForm.telefone = colaborador.telefone.replace(/\D/g, '');
            editForm.email = colaborador.email;
        }
    }
    modalState.value[type] = true;
};

const closeModals = () => {
    modalState.value = {
        create: false,
        edit: false,
        show: false,
        delete: false
    };
    selectedColaborador.value = null;
    createForm.reset();
    editForm.reset();
};

// Submissões
const submitCreate = () => {
    createForm.post(route('colaboradores.store'), {
        onSuccess: () => {
            closeModals();
            // Recarregar a página para mostrar o novo colaborador
            router.reload({ only: ['colaboradores'] });
        },
        onError: () => {
            // Manter o modal aberto se houver erro
        }
    });
};

const submitEdit = () => {
    if (!selectedColaborador.value) return;
    
    editForm.put(route('colaboradores.update', selectedColaborador.value.id), {
        onSuccess: () => {
            closeModals();
            // Recarregar a página para mostrar as alterações
            router.reload({ only: ['colaboradores'] });
        },
        onError: () => {
            // Manter o modal aberto se houver erro
        }
    });
};

const submitDelete = () => {
    if (!selectedColaborador.value) return;
    
    router.delete(route('colaboradores.destroy', selectedColaborador.value.id), {
        onSuccess: () => {
            closeModals();
            // Recarregar a página para remover o colaborador da lista
            router.reload({ only: ['colaboradores'] });
        }
    });
};

// Função para limpar pesquisa
const clearSearch = () => {
    search.value = '';
};
</script>

<template>
    <Head title="Colaboradores" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Colaboradores
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Gerencie os colaboradores da sua empresa
                    </p>
                </div>
                <button
                    @click="openModal('create')"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Novo Colaborador</span>
                </button>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Card Principal -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <!-- Header do Card -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 space-y-4 sm:space-y-0">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Lista de Colaboradores
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Total de {{ colaboradores.total }} colaboradores
                                </p>
                            </div>
                            
                            <!-- Barra de Pesquisa -->
                            <div class="flex-1 sm:max-w-md">
                                <ColaboradorSearch
                                    v-model="search"
                                    :loading="isLoading"
                                    @search="router.get(route('colaboradores.index'), { search })"
                                    @clear="clearSearch"
                                />
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div v-if="isLoading" class="flex justify-center items-center py-12">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        </div>

                        <!-- Conteúdo -->
                        <template v-else>
                            <!-- Tabela ou Estado Vazio -->
                            <template v-if="colaboradores.data.length > 0">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <ColaboradorTable
                                        :colaboradores="colaboradores.data"
                                        @view="openModal('show', $event)"
                                        @edit="openModal('edit', $event)"
                                        @delete="openModal('delete', $event)"
                                    />
                                </div>

                                <ColaboradorPagination
                                    :links="colaboradores.links"
                                    :current-page="colaboradores.current_page"
                                    :total="colaboradores.total"
                                    :showing="colaboradores.data.length"
                                    class="mt-6"
                                />
                            </template>

                            <ColaboradorEmptyState
                                v-else
                                :has-search="!!search"
                                @create="openModal('create')"
                                @clear-search="clearSearch"
                            />
                        </template>
                    </div>
                </div>

                <!-- Estatísticas Rápidas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-900">Total de Colaboradores</p>
                                <p class="text-2xl font-bold text-blue-800 mt-1">{{ colaboradores.total }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-900">Colaboradores Ativos</p>
                                <p class="text-2xl font-bold text-green-800 mt-1">
                                    {{ colaboradores.data.filter(c => c.ativo).length }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-900">Cadastrados Este Mês</p>
                                <p class="text-2xl font-bold text-purple-800 mt-1">
                                    {{ colaboradores.data.filter(c => {
                                        const created = new Date(c.created_at.split('/').reverse().join('-'));
                                        const now = new Date();
                                        return created.getMonth() === now.getMonth() && created.getFullYear() === now.getFullYear();
                                    }).length }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modais -->
        <CreateColaboradorModal
            :show="modalState.create"
            :form="createForm"
            @close="closeModals"
            @submit="submitCreate"
        />

        <EditColaboradorModal
            v-if="selectedColaborador"
            :show="modalState.edit"
            :colaborador="selectedColaborador"
            :form="editForm"
            @close="closeModals"
            @submit="submitEdit"
        />

        <ShowColaboradorModal
            v-if="selectedColaborador"
            :show="modalState.show"
            :colaborador="selectedColaborador"
            @close="closeModals"
        />

        <DeleteColaboradorModal
            v-if="selectedColaborador"
            :show="modalState.delete"
            :colaborador="selectedColaborador"
            @close="closeModals"
            @confirm="submitDelete"
        />
    </AuthenticatedLayout>
</template>