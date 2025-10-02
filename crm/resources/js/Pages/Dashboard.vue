<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatsCards from './Dashboard/StatsCards.vue';
import EvolutionTable from './Dashboard/EvolutionTable.vue';
import QuickActions from './Dashboard/QuickActions.vue';

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
                <!-- Estatísticas em Cards -->
                <StatsCards :stats="stats" />
                
                <!-- Evolução Mensal -->
                <EvolutionTable 
                    :evolucao-mensal="evolucaoMensal" 
                    class="mb-8" 
                />
                
                <!-- Ações Rápidas -->
                <QuickActions />
            </div>
        </div>
    </AuthenticatedLayout>
</template>