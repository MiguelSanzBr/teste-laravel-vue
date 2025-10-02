<script setup lang="ts">
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const user = usePage().props.auth.user;

// Função para formatar CNPJ
const formatCNPJ = (cnpj: string): string => {
    if (!cnpj) return '';
    const cleaned = cnpj.replace(/\D/g, '');
    if (cleaned.length !== 14) return cnpj;
    
    return cleaned.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
};

const form = useForm({
    cnpj: formatCNPJ(user.cnpj || ''),
    nmfs: user.nmfs || '',
    rsl: user.rsl || '',
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Perfil atualizado com sucesso!');
        },
        onError: (errors) => {
            console.log('Erros no formulário:', errors);
        },
    });
};
</script>

<template>
    <section class="bg-white rounded-lg shadow-sm p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações da Empresa
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Atualize as informações da sua empresa.
            </p>
        </header>

        <form
            @submit.prevent="submit"
            class="mt-6 space-y-6"
        >
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

            <div>
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

            <div>
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

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    <span v-if="form.processing">Salvando...</span>
                    <span v-else>Salvar</span>
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-green-600 font-medium"
                    >
                        Informações salvas com sucesso!
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>