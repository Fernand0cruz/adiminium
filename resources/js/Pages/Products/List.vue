<template>
    <AuthenticatedLayout>
        <!-- TITLE -->
        <div class="mb-4">
            <SectionTitle title="Produtos cadastrados no sistema" />
            <SectionSubTitle
                subTitle="Listagem dos produtos com opção de deletar produto ou editar"
            />
        </div>

        <!-- ERROS MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- PRODUCT TABLE -->
        <ProductTable
            v-if="products && products.length > 0"
            :products="products"
        />

        <!-- PAGINATION -->
        <div
            v-if="products && products.length > 0"
            class="flex justify-center items-center mt-4 space-x-2"
        >
            <button
                v-if="pagination.prev_page_url"
                @click="loadData(currentPage - 1)"
                class="px-4 py-2 bg-gray-200 rounded-md"
            >
                Anterior
            </button>

            <span
                >Página {{ pagination.current_page }} de
                {{ pagination.last_page }}</span
            >

            <button
                v-if="pagination.next_page_url"
                @click="loadData(currentPage + 1)"
                class="px-4 py-2 bg-gray-200 rounded-md"
            >
                Próxima
            </button>
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

const products = ref(null);
const errorMessage = ref(null);
const pagination = ref({});
const currentPage = ref();

const loadData = async (page = 1) => {
    try {
        const response = await Services.products.get(page);
        products.value = response.data.data;
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            per_page: response.data.per_page,
            total: response.data.total,
            next_page_url: response.data.next_page_url,
            prev_page_url: response.data.prev_page_url,
        };
        currentPage.value = page;
        errorMessage.value = null;
    } catch (error) {
        console.error("Erro ao carregar produtos:", error);
        errorMessage.value =
            "Erro ao carregar listagem com os produtos. Tente novamente mais tarde!";
    }
};

onMounted(loadData);
</script>
