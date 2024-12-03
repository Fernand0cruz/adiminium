<script setup>
import { computed } from 'vue';
import PrimaryButton from './PrimaryButton.vue';
import DangerButton from './DangerButton.vue';

const props = defineProps({
    label: String,
});

const emits = defineEmits(["closeModal", "confirmDelete"]);

const message = computed(() => {
    return props.label === 'client'
        ? 'Do you really want to delete this client?'
        : 'Do you really want to delete this product?';
});
</script>


<template>
    <h2 class="text-lg font-bold mb-4">Delete Confirmation</h2>

    <p>{{ message }}</p>

    <div class="flex gap-6 justify-end mt-4">
        <PrimaryButton @click="$emit('confirmDelete')">Delete</PrimaryButton>
        
        <DangerButton @click="$emit('closeModal')">Cancel</DangerButton>
    </div>
</template>

<style scoped>
/* Your styles here */
</style>
