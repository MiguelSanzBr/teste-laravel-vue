<template>
    <div class="flex items-center justify-center h-screen bg-gray-100 text-center px-4">
        <h3 class="text-3xl font-semibold text-gray-800">
            Bem vindo ao Teste <span class="text-blue-600">{{ appName }}</span>
        </h3>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const appName = page.props.appName
</script>
