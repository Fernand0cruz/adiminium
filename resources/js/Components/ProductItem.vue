<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    product: Object,
    index: Number,
    section: String,
});

const emits = defineEmits([
    "decrement-quantity",
    "increment-quantity",
    "delete-product-in-order",
]);

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
    <div class="border bg-gray-100 rounded-md p-4">
        <div class="border flex justify-between">
            <div
                class="h-20 w-20 flex justify-center items-center overflow-hidden"
            >
                <img :src="product.product_details?.photo" alt="Product image" />
            </div>

            <div class="p-4 flex-1 text-gray-500">
                <p>
                    <strong>Product: </strong>{{ product.product_details?.name }}
                </p>

                <div class="flex items-center gap-6">
                    <span
                        ><strong>Quantity: {{ product.quantity }}</strong></span
                    >

                    <div v-if="section === 'order'">
                        <button
                            @click="$emit('decrement-quantity', index)"
                            class="border rounded-md bg-white px-2"
                        >
                            -
                        </button>

                        {{ product.quantity }}

                        <button
                            @click="$emit('increment-quantity', index)"
                            class="border rounded-md bg-white px-2"
                        >
                            +
                        </button>

                        <button
                            @click="$emit('delete-product-in-order', index)"
                            class="border rounded-md bg-white px-2 text-red-600"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-4 text-gray-500">
                <p>
                    <strong>Value unit: </strong>R$
                    {{ formatCurrency(product.product_details?.price) }}
                </p>

                <p>
                    <strong>Total: </strong>R$
                    {{
                        formatCurrency(
                            (product.product_details?.price * product.quantity).toFixed(2)
                        )
                    }}
                </p>
            </div>
        </div>
    </div>
</template>
