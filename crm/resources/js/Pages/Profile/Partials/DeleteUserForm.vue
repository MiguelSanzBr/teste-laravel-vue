<script setup lang="ts">
import DangerButton from '@/Components/ui/DangerButton.vue';
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import Modal from '@/Components/ui/Modal.vue';
import SecondaryButton from '@/Components/ui/SecondaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Excluir Conta
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Uma vez que sua conta for excluída, todos os seus recursos e dados serão
                permanentemente excluídos. Antes de excluir sua conta, faça o download de
                quaisquer dados ou informações que deseja manter.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Excluir Conta</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-white">
                <h2 class="text-lg font-medium text-gray-900">
                    Tem certeza que deseja excluir sua conta?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Uma vez que sua conta for excluída, todos os seus recursos e dados
                    serão permanentemente excluídos. Por favor, digite sua senha para
                    confirmar que deseja excluir permanentemente sua conta.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Senha"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Senha"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Excluir Conta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>