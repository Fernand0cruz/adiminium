<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    product: Object,
});

const getProductimageUrl = (imagePath) =>
    imagePath.startsWith("http") ? imagePath : `/storage/${imagePath}`;

const formatCurrency = (value) => {
    if (!value) return "R$ 0,00"; 

    const number = parseFloat(value);
    if (isNaN(number)) return "R$ 0,00"; 

    return `R$ ${number.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })}`;
};
</script>

<template>
    <div class="transform transition-transform duration-200 hover:scale-105">
        <div class="rounded-md p-6 border flex flex-col gap-2">
            <div
                class="h-52 flex border justify-center items-center rounded-md bg-gray-100 p-6 overflow-hidden"
            >
                <img
                    class="mx-auto"
                    v-if="product.image"
                    :src="getProductimageUrl(product.image)"
                    alt="Product image"
                />
            </div>

            <div class="flex flex-col">
                <h2 class="font-semibold text-lg truncate">
                    Product: {{ product.name }}
                </h2>

                <span class="text-gray-500"
                    ><strong>Unit Price: </strong> {{ formatCurrency(product.price) }}</span
                >

                <span class="text-gray-500"
                    ><strong>Stock Quantity: </strong
                    >{{ product.stock_quantity }}</span
                >
            </div>

            <div class="flex flex-col gap-2">
                <PrimaryButton
                    @click="$emit('viewProduct', product.id)"
                    class="justify-center"
                    >View Product</PrimaryButton
                >

                <PrimaryButton
                    @click="$emit('openModal', product)"
                    class="justify-center"
                    >Place Order</PrimaryButton
                >
            </div>
        </div>
    </div>
</template>
