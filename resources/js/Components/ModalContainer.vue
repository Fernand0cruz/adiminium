<script setup>
const props = defineProps({});
</script>

<template>
    <div
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
    >
        <div
            class="bg-white rounded-lg p-6 w-[750px] flex flex-col"
        >
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
/* Your styles here */
</style>
