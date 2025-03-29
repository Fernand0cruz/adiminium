<template>
    <!-- ERROR MESSAGE -->
    <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

    <div class="grid grid-cols-1 sm:grid-cols-2  xl:grid-cols-4 gap-4">

        <div v-for="product in products" :key="product.id"
            class="border rounded-lg p-4 bg-gray-100">
            <div
                class="relative h-[350px] sm:h-[250px] xl:h-[250px] border overflow-hidden rounded-lg p-4 flex justify-center items-center bg-white">
                <img :src="getProductPhotoUrl(product.photo)" :alt="product.name"
                    class="max-h-full max-w-full object-contain" />
                <div v-if="product.discount > 0"
                    class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    {{ product.discount }}% OFF
                </div>
            </div>

            <div class="mt-4">
                <span class="truncate block">{{ product.name }}</span>

                <div class="flex">
                    <p v-if="product.discount > 0">Preço: De {{ product.price }} por {{ product.final_price }}</p>
                    <p v-else>Preço: {{ product.final_price }}</p>
                </div>
                <span>Quantidade disponível: {{ product.quantity }}</span>
            </div>
            <div class="flex justify-end mt-4 flex-col gap-2">
                <Link :href="route('products.catalog.show', { id: product.id })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle  text-sm">
                <SquareArrowOutUpRight />
                Ver produto
                </Link>
                <button @click="openModal(product)"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle  text-sm">
                    <ShoppingBasket />
                    Adicionar ao pedido
                </button>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen"
         class="z-[75] top-[-17px] fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white w-[650px] rounded-lg overflow-hidden border">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Adicionar ao pedido:</h2>
                <p>Adicionar o produto {{ modalProduct.name}} ao pedido:</p>
                <p class="text-gray-500">Quantidade disponível: {{ modalProduct.quantity }}</p>
                <div>
                    <p v-if="modalProduct.discount > 0" class="text-red-500">
                        {{ modalProduct.discount }}% de desconto!
                    </p>
                    <p class="text-lg font-bold text-gray-500">
                        <span>Preço: </span>
                        <span v-if="modalProduct.discount > 0">De <span class="line-through">{{ modalProduct.price }}</span> por
                        </span>
                        <span class="text-black">{{ modalProduct.final_price }}</span>
                    </p>
                </div>
            </div>
            <div class="bg-gray-100 p-4 flex justify-end gap-4">
                <button @click="closeModal"
                        class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm">
                    Cancelar
                </button>
                <button @click="addProductToOrder(modalProduct)"
                        class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                    <ShoppingBasket />
                    Adicionar ao pedido
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ShoppingBasket, SquareArrowOutUpRight} from "lucide-vue-next";
import {Link, usePage} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import Services from '@/Services/api/index.js';
import ErrorMessage from "@/Components/ErrorMessage.vue";

defineProps({
    products: Array
})

const isModalOpen = ref(false);
const modalProduct = ref(null);
const quantity = ref(1);
const order = ref([]);
const errorMessage = ref(null);
const { props } = usePage();
const user = props.auth.user;

const openModal = (product) => {
    modalProduct.value = product;
    isModalOpen.value = true;
    errorMessage.value = "";
};

const closeModal = () => {
    isModalOpen.value = false;
    modalProduct.value = null;
    quantity.value = 1
};

const getProductPhotoUrl = (photoPath) =>
    photoPath && photoPath.startsWith("http")
        ? photoPath
        : `/storage/${photoPath}`;

onMounted(async () => {
    try {
        order.value = await Services.orders.getOrderActive()
    } catch (error) {
        console.error(error.message?.[0])
    }
})

const addProductToOrder = async (product) => {
    try {
        if (!order.value || !order.value.length) {
            order.value = await Services.orders.create({
                company_id: user.company_id,
                products: [
                    {
                        product_id: product.id,
                        quantity: 1
                    }
                ]
            });

            // toast sucess
            order.value = await Services.orders.getOrderActive();
        } else {
            await Services.orders.update(order.value.id, {
                product_id: product.id,
                quantity: quantity.value,
            });
        }
        closeModal();
    } catch (error) {
        closeModal();
        errorMessage.value = error.message?.[0];
    }
};
</script>
