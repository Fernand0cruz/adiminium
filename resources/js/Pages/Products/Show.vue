<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="product.name || 'Carregando...'" />
                <SectionSubTitle subTitle="Veja mais informações sobre o produto abaixo!" />
            </div>

            <!-- UPDATE PRODUCT -->
            <div v-if="userRole === 'admin'">
                <Link :href="route('admin.products.edit', { id: productId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Package2 />
                Editar Produto
                </Link>
            </div>
        </div>

        <!-- ERROR MESSAGE -->
        <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

        <!-- LOADING DATA -->
        <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Produto...
            </p>
        </div>

        <!-- PRODUCT DETAILS -->
        <div v-if="product.id"
            class="p-4 bg-gray-100 border rounded-lg flex flex-col md:flex-row gap-4 md:min-h-[400px]">
            <!-- PRODUCT DETAILS PHOTO -->
            <div class="w-full md:w-1/2 flex justify-center bg-white rounded-md border p-4">
                <img :src="getProductPhotoUrl(product.photo)" alt="Produto" class="w-full max-w-sm object-contain" />
            </div>

            <!-- PRODUCT DETAILS INFO -->
            <div class="w-full md:w-1/2 space-y-4">
                <h1 class="font-extrabold text-xl">{{ product.name }}</h1>
                <p class="text-gray-500">{{ product.description }}</p>
                <p class="text-gray-500">Quantidade disponível: {{ product.quantity }}
                </p>
                <div>
                    <p v-if="product.discount > 0" class="text-red-500">
                        {{ product.discount }}% de desconto!
                    </p>
                    <p class="text-lg font-bold text-gray-500">
                        <span>Preço: </span>
                        <span v-if="product.discount > 0">De <span class="line-through">{{ product.price }}</span> por
                        </span>
                        <span class="text-black">{{ product.final_price }}</span>
                    </p>
                </div>

                <button v-if="userRole === 'client'" @click="addProductToOrder(product)"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                    Adicionar ao pedido
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { Package2 } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import Services from "@/Services/api/index.js";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { useToast } from "vue-toastification";

const { props } = usePage();
const userRole = props.auth.user.role;
const product = ref({});
const errorMessage = ref(null);
const productId = route().params.id;
const loading = ref(false);
const toast = useToast();
const user = props.auth.user;

onMounted(async () => {
    loading.value = true;
    try {
        product.value = await Services.products.get(productId);
    } catch (error) {
        errorMessage.value = error.message[0];
    } finally {
        loading.value = false;
    }
});

const getProductPhotoUrl = (photoPath) =>
    photoPath && photoPath.startsWith("http")
        ? photoPath
        : `/storage/${photoPath}`;

const addProductToOrder = async (product) => {

    let order = await Services.orders.getOrderActive()

    try {
        if (!order || order.length === 0) {

            const response = await Services.orders.create({
                company_id: user.company_id,
                products: [
                    {
                        product_id: product.id,
                        quantity: 1
                    }
                ]
            });

            toast.success(response.message);
        } else {
            const existingProduct = order[0].products.find(p => p.pivot.product_id === product.id)

            if (existingProduct) {
                const response = await Services.orders.update(order[0].id, {
                    increment_product: {
                        product_id: product.id,
                        quantity: 1
                    }
                });

                toast.success(response.data);
            } else {
                const response = await Services.orders.update(order[0].id, {
                    add_product: {
                        product_id: product.id,
                        quantity: 1
                    }
                });

                toast.success(response.data);
            }
        }

    } catch (error) {
        toast.error(error.message?.[0]);
    }
};
</script>
