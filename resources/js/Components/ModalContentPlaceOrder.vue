<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import NumberInput from "@/Components/NumberInput.vue";

const props = defineProps({
    product: Object,
    stockQuantity: Number,
});

const emit = defineEmits(["submit", "closeModal", "update:stock-quantity"]);
</script>

<template>
    <h2 class="font-semibold text-lg">Product: {{ product.name }}</h2>

    <div class="flex flex-col gap-4 text-gray-500">
        <p><strong>Description:</strong> {{ product.description }}</p>

        <p><strong>Unit Price:</strong> R$ {{ product.price }}</p>

        <p><strong>Stock Quantity:</strong> {{ product.stock_quantity }}</p>
    </div>

    <!-- Todo - componentizar form -->
    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-6">
        <div>
            <InputLabel for="stock_quantity" value="Select Quantity" />

            <NumberInput
                id="stock_quantity"
                class="mt-1 block w-full"
                :modelValue="stockQuantity"
                @update:modelValue="$emit('update:stock-quantity', $event)"
            />
        </div>

        <div class="flex gap-6 justify-end">
            <PrimaryButton>Place Order</PrimaryButton>

            <DangerButton @click="$emit('closeModal')">Cancel</DangerButton>
        </div>
    </form>
</template>

<style scoped>
/* Your styles here */
</style>
