<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BaseModal from './BaseModal.vue';
import ColaboradorForm from '../forms/ColaboradorForm.vue';

interface Props {
    show: boolean;
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
        title="Novo Colaborador"
        @close="$emit('close')"
    >
        <ColaboradorForm
            :form="form"
            submit-text="Criar Colaborador"
            @submit="$emit('submit')"
            @cancel="$emit('close')"
        />
    </BaseModal>
</template>