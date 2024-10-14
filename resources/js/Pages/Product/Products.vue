<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';

// rever: inserir paginação
// criar funcao para requisicao
const { props } = usePage();
const userId = props.auth.user.id;

const products = ref([]);
const isModalOpen = ref(false);
const stock_quantity = ref('1');
const selectedProduct = ref(null);

const successMessage = ref('');
const errorMessage = ref('');

onMounted(async () => await fetchProducts());

const fetchProducts = async () => {
    try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return;
        }

        const response = await axios.get('/api/products', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        products.value = response.data.products;
    } catch (error) {
        errorMessage.value = 'Erro ao carregar produtos';
    }
};


const getProductPhotoUrl = (photoPath) => photoPath.startsWith('http') ? photoPath : `/storage/${photoPath}`;

const showProduct = (id) => window.location.href = `/product/${id}`;

const openModal = (product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
    successMessage.value = '';
    errorMessage.value = '';
};

const closeModal = () => {
    isModalOpen.value = false;
    stock_quantity.value = '1'
};

//rever
const handleStockQuantityInput = (event) => {
    const cleaned = event.target.value.replace(/\D/g, '');
    const numericValue = parseInt(cleaned, 10);

    if (selectedProduct.value) {
        if (numericValue <= 0) {
            stock_quantity.value = '1';
            errorMessage.value = 'A quantidade deve ser maior que zero.';
        } else if (numericValue > selectedProduct.value.stock_quantity) {
            stock_quantity.value = selectedProduct.value.stock_quantity.toString();
            errorMessage.value = 'Quantidade selecionada excede o estoque disponível.';
        } else {
            stock_quantity.value = cleaned;
            errorMessage.value = '';
        }
    }
};

const submit = async () => {
    try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return;
        }
        const response = await axios.post('/api/order', {
            client_id: userId,
            product_id: selectedProduct.value.id,
            quantity: stock_quantity.value
        }, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });

        if (response.data.success) {
            successMessage.value = response.data.success || 'Produto adicionado aos seus pedidos com sucesso!';
            errorMessage.value = '';
            closeModal();
        } else {
            errorMessage.value = response.data.error || 'Ocorreu um erro ao fazer o pedido.';
            successMessage.value = '';
        }
    } catch (error) {
        errorMessage.value = error.response?.data.error || 'Erro ao conectar com o servidor.';
        successMessage.value = '';
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-5">Produtos Disponíveis</h1>
                        <div v-if="successMessage"
                            class="mb-4 p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                            {{ successMessage }}
                        </div>
                        <div v-if="errorMessage"
                            class="mb-4 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                            {{ errorMessage }}
                        </div>
                        <div v-if="products.length === 0" class="text-gray-600">
                            Nenhum produto disponível no momento.
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div v-for="product in products" :key="product.id"
                                class="transform transition-transform duration-200 hover:scale-105">
                                <div class="rounded-md p-4 bg-gray-100">
                                    <div class="h-52 border flex justify-center items-center overflow-hidden">
                                        <img class="mx-auto" v-if="product.photo"
                                            :src="getProductPhotoUrl(product.photo)" alt="Imagem do produto" />
                                    </div>
                                    <div class="flex flex-col mt-4">
                                        <h1 class="font-semibold text-lg text-nowrap overflow-hidden text-ellipsis">
                                            Produto: {{ product.name }}
                                        </h1>
                                        <span>Preço: R$ {{ product.price }}</span>
                                        <span>Quantidade em estoque: {{ product.stock_quantity }}</span>
                                    </div>
                                    <div class="flex flex-col gap-2 mt-4">
                                        <PrimaryButton @click="showProduct(product.id)" class="justify-center">Ver
                                            Produto</PrimaryButton>
                                        <PrimaryButton class="justify-center" @click="openModal(product)">Fazer Pedido
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
            aria-modal="true">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[750px] flex flex-col gap-4">
                <h2 class="text-lg font-bold mb-4">Fazer pedido</h2>
                <div v-if="errorMessage"
                    class="p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                    {{ errorMessage }}
                </div>
                <h1>Produto - {{ selectedProduct.name }}</h1>
                <h2 class="text-xl font-bold">{{ selectedProduct.name }}</h2>
                <p><strong>Descrição:</strong> {{ selectedProduct.description }}</p>
                <p><strong>Preço:</strong> R$ {{ selectedProduct.price }}</p>
                <p><strong>Quantidade em Estoque:</strong> {{ selectedProduct.stock_quantity }}</p>
                <form @submit.prevent="submit" class="flex flex-col gap-5">
                    <div>
                        <InputLabel for="stock_quantity" value="Selecionar Quantidade" />
                        <TextInput id="stock_quantity" type="text" class="mt-1 block w-full" v-model="stock_quantity"
                            @input="handleStockQuantityInput" min="1" autocomplete="off" required />
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton>
                            Fazer Pedido
                        </PrimaryButton>
                        <button @click.prevent="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
