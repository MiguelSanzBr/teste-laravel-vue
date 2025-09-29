<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid lg:grid-cols-2 grid-cols-1 w-full min-h-screen">
        <!-- Formulário de Registro -->
        <div class="w-full min-h-screen flex flex-col justify-center items-center bg-gray-100 lg:rounded-e-2xl px-4 py-8">
            <div class="bg-white p-6 lg:p-8 rounded-lg shadow-lg border border-gray-300 max-w-md w-full">
                <div class="flex flex-col items-center justify-center mb-6">
                    <Link href="/">
                        <ApplicationLogo class="h-20 w-20 fill-current text-gray-500 mb-4" />
                    </Link>
                </div>
                
                <!-- Slot para os inputs do formulário -->
                <slot />
                
            </div>
        </div>

        <!-- Seção Lateral - Oculta em mobile -->
        <div class="hidden lg:flex w-full h-full bg-blue-600 rounded-s-2xl text-white flex-col justify-center pl-12 xl:pl-20 gap-6 lg:gap-10 pr-8">
            <h2 class="font-bold text-4xl xl:text-6xl">CRM</h2>
            <h2 class="font-semibold text-3xl xl:text-5xl">Laravel+Inertia+Vue</h2>
            <p class="font-medium text-lg xl:text-xl text-blue-100">Organize seus colaboradores e otimize operações com praticidade</p>
            <p class="font-medium text-lg xl:text-xl text-blue-100">Tudo em um só lugar, com alto desempenho e segurança para o seu negócio</p>
        </div>
    </div>
</template>