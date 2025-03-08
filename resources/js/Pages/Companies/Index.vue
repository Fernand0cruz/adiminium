<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Empresas cadastradas no sistema" />
                <SectionSubTitle subTitle="Listagem das empresas com opção de deletar empresas ou editar!" />
            </div>

            <!-- ADD NEW COMPANY -->
            <div>
                <Link :href="route('admin.companies.create')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <SquareChartGantt />
                Nova Empresa
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Empresas...
            </p>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- INFO MESSAGE -->
        <InfoMessage v-if="!loading && !errorMessage && companies.length === 0"
            infoMessage="Não foi encontrado empresas no sistema!" />

        <div v-if="companies && companies.length > 0" class="space-y-4">
            <!-- PRODUCT TABLE -->
            <TableCompanies :companies="companies" @companieDeleted="loadData(currentPage)" /> 

            <!-- PAGINATION -->
            <Pagination :currentPage="currentPage" :lastPage="pagination?.last_page"
                @update:currentPage="handlePageChange" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { ref, onMounted } from "vue";
import Services from "@/Services/index.js";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import InfoMessage from "@/Components/InfoMessage.vue";
import { SquareChartGantt } from "lucide-vue-next";
import { resetState } from "@/Utils/resetState";
import Pagination from "@/Components/Pagination.vue";
import TableCompanies from "@/Components/TableCompanies.vue";

const companies = ref([]);
const errorMessage = ref(null);
const pagination = ref({
    last_page: 1,
});
const currentPage = ref(1);
const loading = ref(false);

const loadData = async (page = 1) => {
    if (loading.value) return;

    resetState({ companies, errorMessage, pagination, currentPage, loading });

    try {
        const response = await Services.companies.getAll(page);
        companies.value = response.data.data;
        pagination.value = response.data;
        currentPage.value = page;
        window.scrollTo({ top: 0 });
    } catch (error) {
        errorMessage.value = error.message[0];
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
