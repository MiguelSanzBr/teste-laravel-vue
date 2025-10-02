<script setup>
defineProps({
    evolucaoMensal: Array
});
</script>

<template>
    <div 
        class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-200" 
        v-if="evolucaoMensal && evolucaoMensal.length > 0"
    >
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
                        <tr 
                            v-for="mes in evolucaoMensal" 
                            :key="mes.mes" 
                            class="hover:bg-gray-50 transition-colors"
                        >
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
                                    <div 
                                        class="w-2 h-2 rounded-full mr-2" 
                                        :class="(mes.cadastrados - mes.demitidos) >= 0 ? 'bg-green-500' : 'bg-red-500'"
                                    ></div>
                                    <span 
                                        class="text-sm font-bold" 
                                        :class="(mes.cadastrados - mes.demitidos) >= 0 ? 'text-green-600' : 'text-red-600'"
                                    >
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
</template>