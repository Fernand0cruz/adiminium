<template>
    <div class="border p-4 rounded-lg">
        <div v-for="product in order.products" :key="product.id"
            class="border p-4 rounded-lg bg-gray-100 flex items-center mb-4">
            <div>
                <img class="object-cover size-16 rounded-lg bg-white border" :src="product.image" :alt="product.name" />
            </div>

            <div class="flex-grow px-4">
                <div class="font-semibold">{{ product.name }}</div>
                <div class="text-sm text-gray-600">
                    <p>Preço da unidade {{ formatCurrency(product.pivot.price) }}</p>
                    <p>Porcentagem de desconto {{ product.pivot.discount }} %</p>
                    <p>Quantidade: {{ product.pivot.quantity }}</p>
                    <p>Preço {{ formatCurrency(product.pivot.price) }} - {{ product.pivot.discount }}% =
                        {{ formatCurrency((product.pivot.price * (1 - product.pivot.discount / 100))) }}
                        x {{ product.pivot.quantity }}, total =
                        {{ formatCurrency((product.pivot.price * (1 - product.pivot.discount / 100)) *
                            product.pivot.quantity) }}</p>
                </div>
            </div>

            <div class="flex items-center border rounded-lg p-2">
                <button @click="decrementQuantity(product)" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l">
                    -
                </button>
                <input type="text" class="w-12 h-10 text-center border-x outline-none z-10"
                    v-model="product.pivot.quantity" readonly />
                <button @click="incrementQuantity(product)" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r">
                    +
                </button>

                <div>
                    <button @click="deleteProduct(product)"
                        class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm">
                        <Trash />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="text-lg font-semibold">
                Preço total do Pedido:
                {{ formatCurrency(totalPrice) }}
            </div>
            <div>
                <Link href="route('#')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                Realizar compra
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { Trash } from "lucide-vue-next";
import { formatCurrency } from "../Utils/formatCurrency.js";
import Services from '@/Services/api/index.js';
import { useToast } from "vue-toastification";
import { computed } from "vue";

const props = defineProps({
    order: Object
});

const toast = useToast();
const emit = defineEmits();

const incrementQuantity = async (order) => {
    try {
        await Services.orders.incrementProductToOrderActive(order.pivot.order_id, {
            products: [
                {
                    product_id: order.id,
                    quantity: 1
                }
            ]
        });

        order.pivot.quantity++
    } catch (error) {
        toast.error(error.message[0]);
    }
};

const decrementQuantity = async (order) => {
    await Services.orders.decrementProductToOrderActive(order.pivot.order_id, {
        products: [
            {
                product_id: order.id,
                quantity: 1
            }
        ]
    });

    if (order.pivot.quantity <= 1) {
        emit('update-order');
    } else {
        order.pivot.quantity--;
    }
};

const deleteProduct = async (product) => {
    await Services.orders.removeProductToOrderActive(product.pivot.order_id, {
        products: [
            {
                product_id: product.id,
                quantity: product.pivot.quantity
            }
        ]
    });

    emit('update-order', { isLoading: true });
};

const totalPrice = computed(() => {
    return props.order?.products?.reduce((total, product) => {
        const discountedPrice = product.pivot.price * (1 - product.pivot.discount / 100);
        return total + (discountedPrice * product.pivot.quantity);
    }, 0) || 0;
});

</script>
