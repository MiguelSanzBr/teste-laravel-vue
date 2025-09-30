<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeSection = ref('profile');
</script>

<template>
    <Head title="Gerenciar Perfil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Configurações da Empresa
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Gerencie suas informações empresariais e configurações de conta
                        </p>
                    </div>
                </div>
                
                <!-- Navegação por abas -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button
                            @click="activeSection = 'profile'"
                            :class="[
                                activeSection === 'profile'
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200'
                            ]"
                        >
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>Informações da Empresa</span>
                            </div>
                        </button>
                        <button
                            @click="activeSection = 'security'"
                            :class="[
                                activeSection === 'security'
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200'
                            ]"
                        >
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Segurança</span>
                            </div>
                        </button>
                        <button
                            @click="activeSection = 'danger'"
                            :class="[
                                activeSection === 'danger'
                                    ? 'border-red-500 text-red-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200'
                            ]"
                        >
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Zona de Risco</span>
                            </div>
                        </button>
                    </nav>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-6xl">
                <!-- Seção de Informações da Empresa -->
                <div v-show="activeSection === 'profile'" class="space-y-6 animate-fade-in">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm border border-blue-200">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Dados Empresariais</h3>
                                    <p class="text-sm text-gray-600 mt-1">Atualize as informações legais da sua empresa</p>
                                </div>
                            </div>
                            <div class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                Obrigatório
                            </div>
                        </div>
                        <UpdateProfileInformationForm class="mt-6" />
                    </div>
                </div>

                <!-- Seção de Segurança -->
                <div v-show="activeSection === 'security'" class="space-y-6 animate-fade-in">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-100">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm border border-green-200">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Segurança da Conta</h3>
                                    <p class="text-sm text-gray-600 mt-1">Proteja sua conta com uma senha forte</p>
                                </div>
                            </div>
                            <div class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">
                                Recomendado
                            </div>
                        </div>
                        <UpdatePasswordForm class="mt-6" />
                    </div>
                </div>

                <!-- Seção de Zona de Risco -->
                <div v-show="activeSection === 'danger'" class="space-y-6 animate-fade-in">
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl p-8 border border-red-100">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm border border-red-200">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Ações Irreversíveis</h3>
                                    <p class="text-sm text-gray-600 mt-1">Cuidado: estas ações não podem ser desfeitas</p>
                                </div>
                            </div>
                            <div class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                                Perigoso
                            </div>
                        </div>
                        <DeleteUserForm class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>