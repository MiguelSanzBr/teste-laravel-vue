<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

interface Props {
    form: ReturnType<typeof useForm<{
        nome: string;
        telefone: string;
        email: string;
    }>>;
    submitText: string;
}

defineProps<Props>();

defineEmits<{
    submit: [];
    cancel: [];
}>();
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="space-y-4">
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome completo</label>
            <input
                id="nome"
                v-model="form.nome"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
            <div v-if="form.errors.nome" class="text-red-500 text-sm mt-1">
                {{ form.errors.nome }}
            </div>
        </div>

        <div>
            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input
                id="telefone"
                v-model="form.telefone"
                type="tel"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
            <div v-if="form.errors.telefone" class="text-red-500 text-sm mt-1">
                {{ form.errors.telefone }}
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                {{ form.errors.email }}
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <button
                type="button"
                @click="$emit('cancel')"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium transition-colors"
            >
                Cancelar
            </button>
            <button
                type="submit"
                :disabled="form.processing"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-medium disabled:opacity-50 transition-colors"
            >
                {{ submitText }}
            </button>
        </div>
    </form>
</template>