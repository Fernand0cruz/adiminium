<script setup>

const props = defineProps({});
</script>

<template>
    <div class="w-64 bg-gray-100 p-6 rounded-md border h-screen">
        <nav>
            <ul class="flex flex-col gap-4">
                <slot></slot>
            </ul>
        </nav>
    </div>
</template>

<style scoped>
/* Your styles here */
</style>
