<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputError from "./InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { watch } from "vue";

const props = defineProps({
    product: Object,
    userRole: String,
    form: Object,
});

const emits = defineEmits(["handleSubmit", "edit"]);

const formatCurrency = (value) => {
    if (!value) return "R$ 0,00";

    const number = parseFloat(value);
    if (isNaN(number)) return "R$ 0,00";

    return `R$ ${number.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })}`;
};

const getProductPhotoUrl = (photoPath) =>
    photoPath && photoPath.startsWith("http")
        ? photoPath
        : `/storage/${photoPath}`;

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
    <div class="flex w-full border p-6 rounded-md">
        <div
            class="w-1/2 flex justify-center items-center p-6 product-image-container"
        >
            <img
                class="max-h-[400px]"
                v-if="product.photo"
                :src="getProductPhotoUrl(product.photo)"
                alt="Product image"
            />
        </div>

        <div
            class="w-1/2 bg-gray-100 rounded-md border p-6 flex flex-col gap-6"
        >
            <h1 class="font-semibold text-lg">Product: {{ product.name }}</h1>

            <div class="text-gray-500 flex flex-col gap-4">
                <p><strong>Description:</strong> {{ product.description }}</p>

                <p>
                    <strong>Unit Price:</strong>
                    {{ formatCurrency(product.price) }}
                </p>

                <p>
                    <strong>Stock Quantity:</strong>
                    {{ product.stock_quantity }}
                </p>
            </div>

            <div>
                <!-- TODO: componentizar form -->
                <form
                    v-if="userRole === 'client'"
                    @submit.prevent="$emit('handleSubmit')"
                    class="flex flex-col items-start gap-4"
                >
                    <div class="w-full">
                        <InputLabel
                            for="orderQuantity"
                            value="Select Quantity"
                        />

                        <NumberInput
                            id="orderQuantity"
                            class="mt-1 block w-full"
                            v-model="form.orderQuantity"
                            required
                        />

                        <InputError
                            class="mt-2"
                            :message="
                                props.form.errors['products_data.0.quantity']
                            "
                        />
                    </div>

                    <PrimaryButton>Place Order</PrimaryButton>
                </form>

                <div v-if="userRole === 'admin'">
                    <PrimaryButton @click="$emit('edit', product)"
                        >Edit Product</PrimaryButton
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.product-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.product-image-container img {
    transition: transform 0.3s ease, opacity 0.3s ease;
    transform-origin: center;
}

.product-image-container img:hover {
    transform: scale(1.1);
}
</style>
