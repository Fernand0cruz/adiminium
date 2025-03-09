<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="'Editar empresa: ' + (company.business_name || 'Carregando...')" />
                <SectionSubTitle subTitle="Edite os campos abaixo para modificar dados da empresa no sistema!" />
            </div>

            <!-- UPDATE COMPANY -->
            <div>
                <Link :href="route('admin.companies.show', { id: companyId })" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                    <SquareChartGantt />
                    Ver Empresa
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Produtos...
            </p>
        </div>

        <!-- FORM FOR EDIT COMPANY IN THE SYSTEM -->
        <CompanyForm :company="company" :errorMessage="errorMessage" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { Link } from "@inertiajs/vue3";
import { SquareChartGantt } from "lucide-vue-next";
import { onMounted, ref } from "vue";
import Services from "@/Services";
import CompanyForm from "@/Components/CompanyForm.vue";

const companyId = route().params.id;
const company = ref({});
const errorMessage = ref(null);
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    try {
        const { cnpj, phone, zip_code, ...rest } = await Services.companies.get(companyId);
        company.value = {
            ...rest,
            cnpj: cnpj.replace(/\D/g, ''),
            phone: phone.replace(/\D/g, ''),
            zip_code: zip_code.replace(/\D/g, ''),
        };
    } catch (error) {
        errorMessage.value = error.message?.[0];
    } finally {
        loading.value = false;
    }
});
</script>
