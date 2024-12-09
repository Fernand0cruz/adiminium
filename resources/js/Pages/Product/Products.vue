<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import ModalContentPlaceOrder from "@/Components/ModalContentPlaceOrder.vue";
import { onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { fetchProducts, createOrder } from "@/Services/api";
import { useToast } from "vue-toastification";

const toast = useToast();
const { props } = usePage();
const products = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const isLoading = ref(false);
const isModalOpen = ref(false);
const selectedProduct = ref(null);

const form = useForm({
    orderQuantity: 1,
});

const loadProducts = async (page) => {
    isLoading.value = true;
    try {
        const response = await fetchProducts(page);
        products.value = response.data;
        currentPage.value = response.current_page;
        lastPage.value = response.last_page;
        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => loadProducts(currentPage.value));

const openModal = (product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const submit = async () => {
    try {
        const response = await createOrder({
            client_id: props.auth.user.id,
            products_data: [
                {
                    product_id: selectedProduct.value.id,
                    price: selectedProduct.value.price,
                    quantity: form.orderQuantity,
                },
            ],
        });
        toast.success(response);
        closeModal();
    } catch (error) {       
        if (error.errors) {
            Object.entries(error.errors).forEach(([key, messages]) => {
                form.setError(key, messages[0]);
            });
        } else {
            toast.error(error.message);
        }
    }
};
</script>
<template>
    <AuthenticatedLayout>
        <LoadingPlaceholder v-if="isLoading" />

        <div v-else class="flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-lg">Available Products</h1>

                <p v-if="products.length > 0" class="text-gray-500">
                    Current page: {{ currentPage }}
                </p>
            </div>

            <ProductsGrid :products="products" @openModal="openModal" />

            <Pagination
                v-if="products.length > 0"
                :currentPage="currentPage"
                :lastPage="lastPage"
                @changePage="loadProducts"
            />
        </div>

        <ModalContainer v-if="isModalOpen">
            <ModalContentPlaceOrder
                :product="selectedProduct"
                :form="form"
                @submit="submit"
                @closeModal="closeModal"
            />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
