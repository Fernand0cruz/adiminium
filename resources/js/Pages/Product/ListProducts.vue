<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import Pagination from "@/Components/Pagination.vue";
import ProductsTable from "@/Components/ProductsTable.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import ModalContentDeleteItem from "@/Components/ModalContentDeleteItem.vue";
import { onMounted, ref } from "vue";
import { deleteProduct, fetchProducts } from "@/Services/api";
import { useToast } from "vue-toastification";

const toast = useToast();
const products = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const isLoading = ref(false);
const isModalOpen = ref(false);
const selectedProduct = ref(null);

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

const openModal = (itemId) => {
    selectedProduct.value = itemId;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const deleteItem = async () => {
    if (!selectedProduct.value) return;
    try {
        const response = await deleteProduct(selectedProduct.value);
        closeModal();
        loadProducts(currentPage.value);
        toast.success(response);
    } catch (error) {
        toast.error(error.message);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <LoadingPlaceholder v-if="isLoading" />

        <div v-else class="flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-lg">Products in the system</h1>

                <p v-if="products.length > 0" class="text-gray-500">
                    Current page: {{ currentPage }}
                </p>
            </div>

            <ProductsTable :products="products" @openModal="openModal" />
        </div>

        <Pagination
            :currentPage="currentPage"
            :lastPage="lastPage"
            @changePage="loadProducts"
        />

        <ModalContainer v-if="isModalOpen">
            <ModalContentDeleteItem
                label="product"
                @confirmDelete="deleteItem"
                @closeModal="closeModal"
            />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
