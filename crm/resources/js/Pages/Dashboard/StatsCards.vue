<script setup>
defineProps({
    stats: Object
});

const statCards = [
    {
        title: 'Total de Ativos',
        value: 'total_ativos',
        description: 'Colaboradores ativos',
        color: 'blue',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
    },
    {
        title: 'Novos este Mês',
        value: 'cadastrados_mes',
        description: 'Cadastrados',
        color: 'green',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
    },
    {
        title: 'Desligados este Mês',
        value: 'demitidos_mes',
        description: 'Desligamentos',
        color: 'red',
        icon: 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1'
    }
];

const colorClasses = {
    blue: {
        gradient: 'from-blue-500 to-blue-600',
        border: 'border-blue-200',
        text: 'text-blue-300'
    },
    green: {
        gradient: 'from-green-500 to-green-600',
        border: 'border-green-200',
        text: 'text-green-300'
    },
    red: {
        gradient: 'from-red-500 to-red-600',
        border: 'border-red-200',
        text: 'text-red-300'
    },
    purple: {
        gradient: 'from-purple-500 to-purple-600',
        border: 'border-purple-200',
        text: 'text-purple-300'
    }
};

// Função corrigida - recebe stats como parâmetro
const getSaldo = (stats) => {
    const cadastrados = Number(stats?.cadastrados_mes) || 0;
    const demitidos = Number(stats?.demitidos_mes) || 0;
    return cadastrados - demitidos;
};
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Cards Dinâmicos -->
        <div 
            v-for="card in statCards" 
            :key="card.value"
            class="bg-gradient-to-br overflow-hidden shadow-lg rounded-2xl border"
            :class="[colorClasses[card.color].gradient, colorClasses[card.color].border]"
        >
            <div class="p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">{{ card.title }}</p>
                        <p class="text-3xl font-bold mt-2">{{ stats?.[card.value] || 0 }}</p>
                        <p class="text-xs opacity-80 mt-1">{{ card.description }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-white bg-opacity-20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="card.icon" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Saldo (Calculado) -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg rounded-2xl border border-purple-200">
            <div class="p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Saldo do Mês</p>
                        <p class="text-3xl font-bold mt-2" 
                           :class="getSaldo(stats) >= 0 ? 'text-green-300' : 'text-red-300'">
                            {{ getSaldo(stats) }}
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
</template>