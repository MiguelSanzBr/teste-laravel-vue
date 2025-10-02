<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BaseModal from './BaseModal.vue';
import ColaboradorForm from '../forms/ColaboradorForm.vue';

interface Colaborador {
    id: number;
    nome: string;
    telefone: string;
    email: string;
}

interface Props {
    show: boolean;
    colaborador: Colaborador;
    form: ReturnType<typeof useForm<{
        nome: string;
        telefone: string;
        email: string;
    }>>;
}

defineProps<Props>();

defineEmits<{
    close: [];
    submit: [];
}>();
</script>

<template>
    <BaseModal
        :show="show"
        title="Editar Colaborador"
        @close="$emit('close')"
    >
        <ColaboradorForm
            :form="form"
            submit-text="Atualizar"
            @submit="$emit('submit')"
            @cancel="$emit('close')"
        />
    </BaseModal>
</template>