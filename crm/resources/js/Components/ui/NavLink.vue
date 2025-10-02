<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active?: boolean;
}>();
</script>

<template>
    <Link 
        :href="href"
        class="block w-full transition-all duration-300 ease-in-out"
    >
        <slot />
    </Link>
</template>