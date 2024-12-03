<script setup>
import ProductCard from "./ProductCard.vue";

const props = defineProps({
    products: Array,
});

const viewProduct = (productId) => {
    window.location.href = `/product/${productId}`;
};

const emits = defineEmits(["openModal"]);
</script>

<template>
    <div v-if="products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <ProductCard
        v-for="product in products"
            :key="product.id"
            :product="product"
            @openModal="$emit('openModal', product)"
            @viewProduct="viewProduct"
        />
    </div>
    <p v-else class="text-gray-500">No products available at the moment.</p>
</template>
