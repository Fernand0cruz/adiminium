<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Produtos cadastrados no sistema" />
                <SectionSubTitle
                    subTitle="Listagem dos produtos com opção de deletar produto ou editar"
                />
            </div>

            <!-- ADD NEW PRODUCT -->
            <div>
                <Link
                    :href="route('admin.products.create')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                >
                    <Package />
                    Novo Produto
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">Carregando Produtos...</p>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- INFO MESSAGE -->
        <InfoMessage
            v-if="!loading && !errorMessage && products.length === 0"
            infoMessage="Não foi encontrado produtos no sistema!"
        />

        <div v-if="products && products.length > 0" class="space-y-4">
            <!-- PRODUCT TABLE -->
            <ProductTable :products="products" />

            <!-- PAGINATION -->
            <Pagination
                :currentPage="currentPage"
                :lastPage="pagination?.last_page"
                @update:currentPage="handlePageChange"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { ref, onMounted } from "vue";
import Services from "@/Services/index.js";
import ProductTable from "@/Components/TableProducts.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Package } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import InfoMessage from "@/Components/InfoMessage.vue";

const products = ref([]);
const errorMessage = ref(null);
const pagination = ref({
    last_page: 1,
});
const currentPage = ref(1);
const loading = ref(false);

const resetState = () => {
    errorMessage.value = null;
    loading.value = true;
};

const loadData = async (page = 1) => {
    if (loading.value) return;

    resetState();

    try {
        const response = await Services.products.get(page);
        products.value = response.data.data;
        pagination.value = response.data;
        currentPage.value = page;

        window.scrollTo({ top: 0 });
    } catch (error) {
        console.error("Erro ao carregar produtos:", error);
        errorMessage.value =
            "Erro ao carregar listagem com os produtos. Tente novamente mais tarde!";
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
