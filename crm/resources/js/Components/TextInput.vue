<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

// Define as props que o componente pode receber
const props = defineProps<{
    placeholder?: string;
}>();

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="w-full rounded-3xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-white dark:text-gray-900 dark:focus:border-blue-400 dark:focus:ring-blue-400"
        v-model="model"
        ref="input"
        :placeholder="placeholder"
    />
</template>