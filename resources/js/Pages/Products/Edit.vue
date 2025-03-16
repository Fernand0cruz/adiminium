<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="'Editar produto: ' + (product.name || 'Carregando...')" />
                <SectionSubTitle subTitle="Edite os campos abaixo para modificar dados do produto no sistema!" />
            </div>

            <!-- UPDATE PRODUCT -->
            <div>
                <Link :href="route('admin.products.show', { id: productId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Package2 />
                Ver Produto
                </Link>
            </div>
        </div>

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Produtos...
            </p>
        </div>

        <!-- FORM FOR EDIT PRODUCT IN THE SYSTEM -->
        <ProductForm :product="product" :errorMessage="errorMessage" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import ProductForm from '@/Components/ProductForm.vue';
import { Link } from "@inertiajs/vue3";
import { Package2 } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import Services from '@/Services/api/index.js';

const productId = route().params.id;
const product = ref({});
const errorMessage = ref(null);
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    try {
        const { price, ...rest } = await Services.products.get(productId);
        const formattedPrice = parseFloat(price.replace("R$", "").trim().replace(".", "").replace(",", "."));
        product.value = { ...rest, price: formattedPrice };
    } catch (error) {
        errorMessage.value = error.message?.[0];
    } finally {
        loading.value = false;
    }
});
</script>
