<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PasswordToggle from '@/Components/ui/PasswordToggle.vue';
import { ref } from 'vue';

const props = defineProps<{
    cnpj: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    cnpj: props.cnpj,
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Redefinir Senha" />

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

            <div class="mt-4">
                <InputLabel for="password" value="Nova Senha" />
                
                <div class="relative">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="mt-1 block w-full pr-10"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="**********"
                        maxlength="12"
                    />
                    <PasswordToggle v-model="showPassword" />
                </div>
                
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Senha" />
                
                <div class="relative">
                    <TextInput
                        id="password_confirmation"
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        class="mt-1 block w-full pr-10"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="**********"
                        maxlength="12"
                    />
                    <PasswordToggle v-model="showPasswordConfirmation" />
                </div>
                
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Redefinir Senha
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>