<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PasswordToggle from '@/Components/ui/PasswordToggle.vue';
import { ref } from 'vue';

const form = useForm({
    cnpj: '',
    nmfs: '',
    rsl: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false); 

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

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
                <InputLabel for="nmfs" value="Nome Fantasia" />

                <TextInput
                    id="nmfs"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nmfs"
                    required
                    autocomplete="organization"
                    placeholder="Ex: Minha Empresa"
                />

                <InputError class="mt-2" :message="form.errors.nmfs" />
            </div>

            <div class="mt-4">
                <InputLabel for="rsl" value="Razão Social" />

                <TextInput
                    id="rsl"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.rsl"
                    required
                    autocomplete="organization"
                    placeholder="Ex: Minha Empresa Ltda"
                />

                <InputError class="mt-2" :message="form.errors.rsl" />
            </div>

              <div class="mt-4">
                <InputLabel for="password" value="Senha" />
                
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
                
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Já tem uma conta?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>