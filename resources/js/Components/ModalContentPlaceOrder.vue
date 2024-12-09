<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "./InputError.vue";
import NumberInput from "@/Components/NumberInput.vue";
import { watch } from "vue";

const props = defineProps({
    product: Object,
    form: Object,
});

const emit = defineEmits(["submit", "closeModal"]);

const clearErrorOnChange = () => {
    watch(
        () => props.form.orderQuantity,
        () => {
            props.form.errors["products_data.0.quantity"] = null;
        }
    );
};
clearErrorOnChange();
</script>

<template>
    <h2 class="font-semibold text-lg">Product: {{ product.name }}</h2>

    <div class="flex flex-col gap-4 text-gray-500">
        <p><strong>Description:</strong> {{ product.description }}</p>
        <p><strong>Unit Price:</strong> R$ {{ product.price }}</p>
        <p><strong>Stock Quantity:</strong> {{ product.stock_quantity }}</p>
    </div>

    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-6">
        <div>
            <InputLabel for="stock_quantity" value="Select Quantity" />

            <NumberInput
                id="stock_quantity"
                class="mt-1 block w-full"
                v-model="form.orderQuantity"
                required
                autofocus
            />

            <InputError
                class="mt-2"
                :message="props.form.errors['products_data.0.quantity']"
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
