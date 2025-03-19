<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Produtos disponíveis" />
                <SectionSubTitle subTitle="Listagem dos produtos disponíveis, boas compras!" />
            </div>

            <!-- ADD NEW PRODUCT -->
            <div>
                <Link :href="route('admin.products.create')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <ShoppingBasket />
                Ver Pedido Ativo
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Produtos...
            </p>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- INFO MESSAGE -->
        <InfoMessage v-if="!loading && !errorMessage && products.length === 0"
            infoMessage="Não foi encontrado produtos no sistema!" />

        <div v-if="products && products.length > 0" class="space-y-4">
            <!-- PRODUCT GRID -->
            <ProductGrid :products="products" />

            <!-- PAGINATION -->
            <Pagination :currentPage="currentPage" :lastPage="pagination?.last_page"
                @update:currentPage="handlePageChange" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { ref, onMounted } from "vue";
import Services from "@/Services/api/index.js";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import InfoMessage from "@/Components/InfoMessage.vue";
import { resetState } from "@/Utils/resetState";
import { ShoppingBasket } from "lucide-vue-next";
import ProductGrid from "@/Components/ProductGrid.vue";

const products = ref([]);
const errorMessage = ref(null);
const pagination = ref({ last_page: 1 });
const currentPage = ref(1);
const loading = ref(false);

const loadData = async (page = 1) => {
    if (loading.value) return;

    resetState({ products, errorMessage, pagination, currentPage, loading });

    try {
        const { data } = await Services.products.getAll(page);
        products.value = data.data;
        pagination.value = data;
        currentPage.value = page;
        window.scrollTo({ top: 0 });
    } catch (error) {
        errorMessage.value = error.message[0]
    } finally {
        loading.value = false;
    }
};

const handlePageChange = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        loadData(page);
    }
};

onMounted(loadData);
</script>
