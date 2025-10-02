<script setup>
import { Link } from '@inertiajs/vue3';

const actions = [
    {
        title: 'Gerenciar Colaboradores',
        description: 'Visualizar, editar e adicionar colaboradores',
        route: 'colaboradores.index',
        color: 'blue',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
    },
    {
        title: 'Adicionar Colaborador',
        description: 'Adicionar um novo colaborador à equipe',
        route: 'colaboradores.index',
        color: 'green',
        icon: 'M12 6v6m0 0v6m0-6h6m-6 0H6'
    }
];

const colorClasses = {
    blue: {
        bg: 'from-blue-50 to-blue-100',
        border: 'border-blue-200',
        hover: 'from-blue-100 to-blue-200',
        icon: 'bg-blue-500 group-hover:bg-blue-600',
        text: 'group-hover:text-blue-700'
    },
    green: {
        bg: 'from-green-50 to-green-100',
        border: 'border-green-200',
        hover: 'from-green-100 to-green-200',
        icon: 'bg-green-500 group-hover:bg-green-600',
        text: 'group-hover:text-green-700'
    }
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-200">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Ações Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Ação 1: Link direto -->
                <Link 
                    :href="route(actions[0].route)" 
                    class="group p-6 bg-gradient-to-r border rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                    :class="[colorClasses[actions[0].color].bg, colorClasses[actions[0].color].border, colorClasses[actions[0].color].hover]"
                >
                    <div class="flex items-center">
                        <div 
                            class="p-3 rounded-lg text-white mr-4 transition-colors"
                            :class="colorClasses[actions[0].color].icon"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="actions[0].icon" />
                            </svg>
                        </div>
                        <div>
                            <h4 
                                class="text-lg font-semibold text-gray-900"
                                :class="colorClasses[actions[0].color].text"
                            >
                                {{ actions[0].title }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-1">{{ actions[0].description }}</p>
                        </div>
                    </div>
                </Link>

                <!-- Ação 2: Com click handler -->
                <div 
                    class="group p-6 bg-gradient-to-r border rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg cursor-pointer"
                    :class="[colorClasses[actions[1].color].bg, colorClasses[actions[1].color].border, colorClasses[actions[1].color].hover]"
                    @click="$inertia.visit(route(actions[1].route), { method: 'get' })"
                >
                    <div class="flex items-center">
                        <div 
                            class="p-3 rounded-lg text-white mr-4 transition-colors"
                            :class="colorClasses[actions[1].color].icon"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="actions[1].icon" />
                            </svg>
                        </div>
                        <div>
                            <h4 
                                class="text-lg font-semibold text-gray-900"
                                :class="colorClasses[actions[1].color].text"
                            >
                                {{ actions[1].title }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-1">{{ actions[1].description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>