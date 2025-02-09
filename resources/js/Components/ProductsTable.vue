<script setup>
import PrimaryButton from './PrimaryButton.vue';
import DangerButton from './DangerButton.vue';

const props = defineProps({
    products: Array,
});

const viewProduct = (productId) => {
    window.location.href = route('products.show', productId)
};

const emits = defineEmits(["openModal"]);

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
    <table v-if="products.length > 0" class="min-w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-4">Product</th>

                <th class="border p-4">Description</th>

                <th class="border p-4">Price</th>

                <th class="border p-4">Qty. in Stock</th>

                <th class="border p-4">Delete</th>

                <th class="border p-4">View</th>
            </tr>
        </thead>

        <tbody>
            <tr
                v-for="product in products"
                :key="product.id"
                class="hover:bg-gray-100 text-gray-500"
            >
                <td class="border p-3">{{ product.name }}</td>

                <td
                    class="border p-3 text-nowrap overflow-hidden text-ellipsis max-w-[300px]"
                >
                    {{ product.description }}
                </td>

                <td class="border p-3"> {{ formatCurrency(product.price) }}</td>

                <td class="border p-3">{{ product.stock_quantity }}</td>

                <td class="border p-3 text-center">
                    <DangerButton @click="$emit('openModal', product.id)"
                        >Delete</DangerButton
                    >
                </td>
                
                <td class="border p-3 text-center">
                    <PrimaryButton @click="viewProduct(product.id)"
                        >View</PrimaryButton
                    >
                </td>
            </tr>
        </tbody>
    </table>
    <p v-else class="text-gray-500">No products available at the moment.</p>
</template>

<style scoped>
/* Your styles here */
</style>
