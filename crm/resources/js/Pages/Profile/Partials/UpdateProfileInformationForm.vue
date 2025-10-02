<script setup lang="ts">
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const page = usePage();
const user = page.props.auth.user;

// Interface para garantir a tipagem
interface AppUser {
    cnpj?: string;
    nmfs?: string;
    rsl?: string;
}

// Cast seguro do usuário
const appUser = user as AppUser;

// Função para formatar CNPJ
const formatCNPJ = (cnpj: string): string => {
    if (!cnpj) return '';
    const cleaned = cnpj.replace(/\D/g, '');
    if (cleaned.length !== 14) return cnpj;
    
    return cleaned.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
};

const form = useForm({
    cnpj: formatCNPJ(appUser.cnpj || ''),
    nmfs: appUser.nmfs || '',
    rsl: appUser.rsl || '',
});

// Função para aplicar máscara de CNPJ em tempo real
const applyCNPJMask = (event: Event) => {
    const target = event.target as HTMLInputElement;
    let value = target.value.replace(/\D/g, '');
    
    if (value.length <= 14) {
        if (value.length > 12) {
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
        } else if (value.length > 8) {
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
        } else if (value.length > 5) {
            value = value.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else if (value.length > 2) {
            value = value.replace(/(\d{2})(\d{0,3})/, '$1.$2');
        }
        form.cnpj = value;
    }
};

const submit = () => {
    // Remove a formatação do CNPJ antes de enviar
    const cleanedData = {
        ...form.data(),
        cnpj: form.cnpj.replace(/\D/g, '')
    };
    
    form.transform(() => cleanedData).patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Perfil atualizado com sucesso!');
        },
        onError: (errors) => {
            console.log('Erros no formulário:', errors);
        },
    });
};

// Diretiva para máscara de CNPJ
const vCnpjMask = {
    mounted(el: HTMLInputElement) {
        el.addEventListener('input', applyCNPJMask);
    },
    unmounted(el: HTMLInputElement) {
        el.removeEventListener('input', applyCNPJMask);
    }
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
                    placeholder="00.000.000/0000-00"
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