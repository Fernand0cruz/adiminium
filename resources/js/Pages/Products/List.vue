<template>
    <AuthenticatedLayout>
        <div class="mb-4">
            <SectionTitle title="Produtos cadastrados no sistema" />
            <SectionSubTitle
                subTitle="Listagem dos produtos com opção de deletar produto ou editar"
            />
        </div>

        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <ProductTable v-if="products" :products="products" />
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

const loadData = async () => {
    try {
        products.value = await Services.products.get();
        errorMessage.value = null;
    } catch (error) {
        console.error("Erro ao carregar produtos:", error);
        errorMessage.value =
            "Erro ao carregar listagem com os produtos. Tente novamente mais tarde.";
    }
};

onMounted(loadData);
</script>
