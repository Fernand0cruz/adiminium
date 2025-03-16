<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="client.name || 'Carregando...'" />
                <SectionSubTitle subTitle="Veja mais informações sobre o cliente abaixo!" />
            </div>

            <!-- UPDATE CLIENT -->
            <div>
                <Link :href="route('admin.clients.edit', { id: clientId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Users />
                Editar Cliente
                </Link>
            </div>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Cliente...
            </p>
        </div>

        <!-- CLIENT DETAILS -->
        <div v-if="client.id" class="border rounded-lg p-4">
            <div class="grid sm:grid-cols-12 gap-4">
                <div class="sm:col-span-3">
                    <div class="border border-indigo-700 bg-indigo-100 rounded-lg py-9">
                        <p class="text-center uppercase p-5 font-extrabold text-indigo-700 text-5xl">
                            {{ client.name.slice(0, 2) }}
                        </p>
                    </div>
                </div>
                <div class="sm:col-span-9">
                    <h3 class="mb-4 font-semibold">Dados do cliente:</h3>
                    <p><strong>Nome:</strong> {{ client.name }}</p>
                    <p><strong>CNPJ:</strong> {{ client.email }}</p>
                    <p><strong>Telefone:</strong> {{ client.phone }}</p>

                    <h3 class="my-4 pt-2 font-semibold border-t">Dados da empresa:</h3>
                    <p><strong>Razao social:</strong> {{ client.company.business_name }}</p>
                    <p><strong>CNPJ:</strong> {{ client.company.cnpj }}</p>
                    <p><strong>Email:</strong> {{ client.company.email }}</p>
                    <p><strong>Telefone:</strong> {{ client.phone }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import { Users } from 'lucide-vue-next';
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import Services from '@/Services/api/index.js';
import ErrorMessage from "@/Components/ErrorMessage.vue";

const client = ref({});
const errorMessage = ref(null);
const clientId = route().params.id;
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    try {
        client.value = await Services.clients.get(clientId);
    } catch (error) {
        errorMessage.value = error.message[0];
    } finally {
        loading.value = false;
    }
});
</script>
