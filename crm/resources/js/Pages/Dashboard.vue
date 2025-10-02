<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    stats: Object,
    evolucaoMensal: Array,
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>  
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Estatísticas em Cards Melhorados -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total de Colaboradores Ativos -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg rounded-2xl border border-blue-200">
                        <div class="p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium opacity-90">Total de Ativos</p>
                                    <p class="text-3xl font-bold mt-2">{{ stats?.total_ativos || 0 }}</p>
                                    <p class="text-xs opacity-80 mt-1">Colaboradores ativos</p>
                                </div>
                                <div class="p-3 rounded-full bg-white bg-opacity-20">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colaboradores Cadastrados no Mês -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg rounded-2xl border border-green-200">
                        <div class="p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium opacity-90">Novos este Mês</p>
                                    <p class="text-3xl font-bold mt-2">{{ stats?.cadastrados_mes || 0 }}</p>
                                    <p class="text-xs opacity-80 mt-1">Cadastrados</p>
                                </div>
                                <div class="p-3 rounded-full bg-white bg-opacity-20">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demitidos no Mês -->
                    <div class="bg-gradient-to-br from-red-500 to-red-600 overflow-hidden shadow-lg rounded-2xl border border-red-200">
                        <div class="p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium opacity-90">Desligados este Mês</p>
                                    <p class="text-3xl font-bold mt-2">{{ stats?.demitidos_mes || 0 }}</p>
                                    <p class="text-xs opacity-80 mt-1">Desligamentos</p>
                                </div>
                                <div class="p-3 rounded-full bg-white bg-opacity-20">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saldo do Mês -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg rounded-2xl border border-purple-200">
                        <div class="p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium opacity-90">Saldo do Mês</p>
                                    <p class="text-3xl font-bold mt-2" 
                                       :class="((stats?.cadastrados_mes || 0) - (stats?.demitidos_mes || 0)) >= 0 ? 'text-green-300' : 'text-red-300'">
                                        {{ (stats?.cadastrados_mes || 0) - (stats?.demitidos_mes || 0) }}
                                    </p>
                                    <p class="text-xs opacity-80 mt-1">Crescimento líquido</p>
                                </div>
                                <div class="p-3 rounded-full bg-white bg-opacity-20">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Evolução Mensal Melhorada -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-200 mb-8" v-if="evolucaoMensal && evolucaoMensal.length > 0">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Evolução Mensal</h3>
                            <span class="text-sm text-gray-500">Últimos 6 meses</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 rounded-tl-lg">Mês</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100">Cadastrados</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100">Desligados</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 rounded-tr-lg">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="mes in evolucaoMensal" :key="mes.mes" class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ mes.mes_nome }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                <span class="text-sm font-semibold text-green-600">{{ mes.cadastrados }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                <span class="text-sm font-semibold text-red-600">{{ mes.demitidos }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full mr-2" 
                                                     :class="(mes.cadastrados - mes.demitidos) >= 0 ? 'bg-green-500' : 'bg-red-500'"></div>
                                                <span class="text-sm font-bold" 
                                                      :class="(mes.cadastrados - mes.demitidos) >= 0 ? 'text-green-600' : 'text-red-600'">
                                                    {{ mes.cadastrados - mes.demitidos }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ações Rápidas Melhoradas -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Ações Rápidas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Link :href="route('colaboradores.index')" 
                                   class="group p-6 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-lg bg-blue-500 text-white mr-4 group-hover:bg-blue-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700">Gerenciar Colaboradores</h4>
                                        <p class="text-sm text-gray-600 mt-1">Visualizar, editar e adicionar colaboradores</p>
                                    </div>
                                </div>
                            </Link>

                            <div class="group p-6 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg cursor-pointer"
                                 @click="$inertia.visit(route('colaboradores.index'), { method: 'get' })">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-lg bg-green-500 text-white mr-4 group-hover:bg-green-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-700">Adicionar Colaborador</h4>
                                        <p class="text-sm text-gray-600 mt-1">Adicionar um novo colaborador à equipe</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>