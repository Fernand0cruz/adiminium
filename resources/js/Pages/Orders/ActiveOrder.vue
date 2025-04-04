<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Seu pedido ativo" />
                <SectionSubTitle subTitle="Clique em comprar para realizar a compra dos produtos no pedido! " />
            </div>

            <!-- VIEW LIST PRODUCTS -->
            <div>
                <Link :href="route('products.catalog.index')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <ChartNoAxesGantt />
                Ver Produdos
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Pedido...
            </p>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- INFO MESSAGE -->
        <InfoMessage v-if="!errorMessage && !loading && order.length === 0"
            infoMessage="Não foi encontrado produtos no seu pedido, adicione produtos no pedido para realizar uma compra!" />

        <!-- COMPONENT ORDER -->
        <div v-if="!loading && order && order.length > 0">
            <Order v-if="order && order.length > 0" :order="order" @update-order="fetchOrder" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { Link } from "@inertiajs/vue3";
import { ChartNoAxesGantt } from "lucide-vue-next";
import SectionTitle from "@/Components/SectionTitle.vue";
import Order from "@/Components/Order.vue"
import InfoMessage from "@/Components/InfoMessage.vue";
import { ref, onMounted } from "vue";
import Services from "@/Services/api/index.js";
import ErrorMessage from "@/Components/ErrorMessage.vue";

const order = ref({});
const loading = ref(false);
const errorMessage = ref(null);

const fetchOrder = async () => {
    loading.value = true;
    try {
        order.value = await Services.orders.getOrderActive();
    } catch (error) {
        errorMessage.value = error.message[0];
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchOrder();
});
</script>
