<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="product.name || 'Carregando...'" />
                <SectionSubTitle
                    subTitle="Veja mais informações sobre o produto abaixo!"
                />
            </div>

            <!-- UPDATE PRODUCT -->
            <div v-if="userRole === 'admin'">
                <Link
                    :href="route('admin.products.edit', { id: productId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                >
                    <Package />
                    Editar Produto
                </Link>
            </div>
        </div>

        <!-- PRODUCT DETAILS -->
        <div
            v-if="product.id"
            class="p-4 border rounded-lg flex flex-col md:flex-row gap-4 md:min-h-[400px]"
        >

            <!-- PRODUCT DETAILS PHOTO -->
            <div
                class="w-full md:w-1/2 flex justify-center bg-gray-100 rounded-md border p-4"
            >
                <img
                    :src="getProductPhotoUrl(product.photo)"
                    alt="Produto"
                    class="w-full max-w-sm object-contain"
                />
            </div>
            
            <!-- PRODUCT DETAILS INFO -->
            <div class="w-full md:w-1/2 space-y-4">
                <h1 class="font-extrabold text-xl">{{ product.name }}</h1>
                <p class="text-gray-500">{{ product.description }}</p>
                <p class="text-gray-500">
                    Quantidade disponível: {{ product.quantity }}
                </p>
                <div>
                    <p v-if="product.discount > 0" class="text-red-500">
                        {{ product.discount }}% de desconto!
                    </p>
                    <p class="text-lg font-bold text-gray-500">
                        <span>Preço: </span>
                        <span v-if="product.discount > 0">
                            De
                            <span class="line-through">{{
                                product.price
                            }}</span>
                            por
                        </span>
                        <span class="text-black">
                            {{ product.final_price }}
                        </span>
                    </p>
                </div>

                <!-- PRODUCT QUANTITY INCLEMENT AND DECLEMENT-->
                <div class="mt-4 flex flex-wrap items-center gap-4">
                    <div class="flex items-center border rounded-lg p-2">
                        <button
                            @click="decrementQuantity"
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l"
                        >
                            -
                        </button>
                        <input
                            type="text"
                            class=" w-12 h-10 text-center border-x outline-none z-10"
                            v-model="quantity"
                            readonly
                        />
                        <button
                            @click="incrementQuantity"
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r"
                        >
                            +
                        </button>
                    </div>
                    <Link
                        href=""
                        class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                    >
                        <Package />
                        Adicionar ao pedido
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { Package } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import Services from "@/Services";

const { props } = usePage();
const userRole = props.auth.user.role;
const product = ref({});
const errorMessage = ref(null);
const productId = route().params.id;
const quantity = ref(1); 

onMounted(async () => {
    try {
        const response = await Services.products.get(productId);
        product.value = response;
    } catch (error) {
        errorMessage.value =
            "Erro ao carregar produto. Tente novamente mais tarde!";
    }
});

const getProductPhotoUrl = (photoPath) =>
    photoPath && photoPath.startsWith("http")
        ? photoPath
        : `/storage/${photoPath}`;

const incrementQuantity = () => {
    if (quantity.value < product.value.quantity) {
        quantity.value++;
    }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};
</script>