<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    cnpj: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Recuperar Senha" />

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Esqueceu sua senha? Sem problemas. Informe seu CNPJ
            e enviaremos um link para redefinir sua senha.
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="cnpj" value="CNPJ" />

                <TextInput
                    id="cnpj"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cnpj"
                    required
                    autofocus
                    autocomplete="cnpj"
                    placeholder="Digite o CNPJ"
                    maxlength="18"
                    v-cnpj-mask
                />

                <InputError class="mt-2" :message="form.errors.cnpj" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Enviar Link de Redefinição
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>