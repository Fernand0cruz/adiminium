<script setup>
import PrimaryButton from "./PrimaryButton.vue";
const props = defineProps({
    client: Object,
});

const emits = defineEmits(["edit"]);
</script>

<template>
    <div class="w-full bg-gray-100 border rounded-md p-6 flex flex-col gap-6">
        <h1 class="font-semibold text-lg">Client: {{ client.name }}</h1>

        <div class="flex flex-col gap-4 text-gray-500">
            <p><strong>Company:</strong> {{ client.company }}</p>

            <p><strong>Email:</strong> {{ client.email }}</p>

            <p><strong>Phone:</strong> {{ client.phone }}</p>
        </div>

        <div>
            <PrimaryButton @click="$emit('edit', client)"
                >Edit Client</PrimaryButton
            >
        </div>
    </div>
</template>
F
<style scoped>
/* Your styles here */
</style>
