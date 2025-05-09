<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="company.business_name || 'Carregando...'" />
                <SectionSubTitle subTitle="Veja mais informações sobre a empresa abaixo!" />
            </div>

            <!-- UPDATE COMPANY -->
            <div>
                <Link :href="route('admin.companies.edit', { id: companyId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <SquareChartGantt />
                Editar Empresa
                </Link>
            </div>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- INFO MESSAGE -->
        <InfoMessage v-if="!loading && !errorMessage && !company.user"
            infoMessage="Por favor, crie um cliente e vincule-o a empresa para começar a usar o sistema!" />

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Empresa...
            </p>
        </div>

        <!-- COMPANY DETAILS -->
        <div v-if="company.id" class="border rounded-lg p-4">
            <div class="grid sm:grid-cols-12 gap-4">
                <div class="sm:col-span-3">
                    <img class="object-cover rounded-lg" :src="getProductimageUrl(company.image)"
                        alt="Logo da empresa" />
                </div>
                <div class="sm:col-span-9">
                    <h3 class="mb-4 font-semibold">Dados da empresa:</h3>
                    <p><strong>Razão Social:</strong> {{ company.business_name }}</p>
                    <p><strong>CNPJ:</strong> {{ company.cnpj }}</p>
                    <p><strong>Telefone:</strong> {{ company.phone }}</p>
                    <p><strong>Email:</strong> {{ company.email }}</p>
                    <p><strong>Site(Rede social):</strong> <a :href="company.web_site" target="_blank"
                            class="text-blue-500 hover:underline">{{ company.web_site }}</a></p>

                    <h3 class="my-4 pt-2 font-semibold border-t">Dados do responsável:</h3>
                    <p><strong>Nome:</strong> {{ company.user ? company.user.name : "Nome do responsável" }} </p>
                    <p><strong>Email:</strong> {{ company.user ? company.user.email : "Email do responsável" }} </p>
                    <p><strong>Telefone:</strong> {{ company.user ? company.user.phone : "Telefone do responsável" }}
                    </p>

                    <h3 class="my-4 pt-2 font-semibold border-t">Endereço da empresa:</h3>
                    <p><strong>Endereço:</strong> {{ company.address }}</p>
                    <p><strong>Estado:</strong> {{ company.state }}</p>
                    <p><strong>Cidade:</strong> {{ company.city }}</p>
                    <p><strong>CEP:</strong> {{ company.zip_code }}</p>
                    <p><strong>Bairro:</strong> {{ company.neighborhood }}</p>
                    <p><strong>Logradouro:</strong> {{ company.street }}</p>
                    <p><strong>Número:</strong> {{ company.number }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { SquareChartGantt } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import Services from "@/Services/api/index.js";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import InfoMessage from "@/Components/InfoMessage.vue";

const company = ref({});
const errorMessage = ref(null);
const companyId = route().params.id;
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    try {
        company.value = await Services.companies.get(companyId)
    } catch (error) {
        errorMessage.value = error.message[0];
    } finally {
        loading.value = false;
    }
});

const getProductimageUrl = (imagePath) =>
    imagePath && imagePath.startsWith("http")
        ? imagePath
        : `/storage/${imagePath}`;
</script>
