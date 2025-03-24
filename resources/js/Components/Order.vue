<template>
    <div class="border p-4 rounded-lg">
        <div v-for="product in order[0].products" :key="product.id" class="border p-4 rounded-lg bg-gray-100 flex items-center mb-4">
            <div>
                <img class="object-cover size-16 rounded-lg bg-white border" :src="product.photo" :alt="product.name"/>
            </div>

            <div class="flex-grow px-4">
                <div class="font-semibold">{{ product.name }}</div>
                <div class="text-sm text-gray-600">
                    Qtd.: {{ product.pivot.quantity }} x Preço: {{ formatCurrency((product.pivot.price - product.pivot.discount)) }} =
                    <span class="font-bold">{{ formatCurrency(((product.pivot.price - product.pivot.discount) * product.pivot.quantity)) }}</span>
                </div>
            </div>

            <div class="flex items-center border rounded-lg p-2">
                <button @click="decrementQuantity(product)" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l">
                    -
                </button>
                <input type="text" class="w-12 h-10 text-center border-x outline-none z-10" v-model="product.pivot.quantity" readonly />
                <button @click="incrementQuantity(product)" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r">
                    +
                </button>

                <div>
                    <button
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm">
                        <Trash />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="text-lg font-semibold">
                Preço total do Pedido: {{ formatCurrency(getTotalPrice()) }}
            </div>
            <div>
                <Link href="route('#')"
                      class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                    Comprar
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { Trash } from "lucide-vue-next";
import { defineProps } from "vue";
import {formatCurrency} from "../Utils/formatCurrency.js";

const props = defineProps({
    order: Array
});

const incrementQuantity = (product) => {
    product.pivot.quantity++;
};

const decrementQuantity = (product) => {
    if (product.pivot.quantity > 1) {
        product.pivot.quantity--;
    }
};

const getTotalPrice = () => {
    return props.order[0].products.reduce((total, product) => {
        return total + (product.pivot.quantity * (product.pivot.price - product.pivot.discount));
    }, 0);
};
</script>
