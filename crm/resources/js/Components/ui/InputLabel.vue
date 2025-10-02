<script setup lang="ts">
defineProps<{
    value?: string;
}>();
</script>

<template>
    <label class="block text-base font-semibold text-gray-900 dark:text-gray-900 mb-2 leading-tight">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>