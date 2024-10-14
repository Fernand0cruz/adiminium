<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

// rever: inserir paginação
const products = ref([]);
const successMessage = ref('');
const errorMessage = ref('');
const isModalOpen = ref(false);
const itemToDelete = ref(null);

onMounted(async () => {
    await fetchProducts();
});

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


const deleteItem = async () => {
    if (!itemToDelete.value) return;
    try {
        const token = localStorage.getItem('auth_token'); 
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return; 
        }
        const response = await axios.delete(`/api/product/${itemToDelete.value}`, {
            headers: {
                Authorization: `Bearer ${token}` 
            }
        });
        if (response.data.success) {
            successMessage.value = response.data.success || 'Produto excluído com sucesso!';
            closeModal();
            fetchProducts();
        } else {
            errorMessage.value = 'Erro inesperado ao excluir o produto';
        }
    } catch (error) {
        errorMessage.value = error.message || 'Erro ao excluir produto';
    }
};

const openModal = (itemId) => {
    itemToDelete.value = itemId;
    isModalOpen.value = true;
    successMessage.value = '';
    errorMessage.value = '';
};

const closeModal = () => {
    isModalOpen.value = false;
    itemToDelete.value = null;
};

const showProduct = (id) => window.location.href = `/product/${id}`;
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-5">Produtos no Sistema</h1>
                        <div v-if="successMessage"
                            class="mb-4 p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                            {{ successMessage }}
                        </div>
                        <div v-if="errorMessage"
                            class="mb-4 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                            {{ errorMessage }}
                        </div>
                        <h1 v-if="(products.length === 0)">Não há produtos para exibir. Cadastre um produto!
                        </h1>
                        <table v-if="(products.length > 0)" class="min-w-full border-collapse border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Produto</th>
                                    <th class="border border-gray-200 px-4 py-2">Descrição</th>
                                    <th class="border border-gray-200 px-4 py-2">Preço</th>
                                    <th class="border border-gray-200 px-4 py-2">Qtd. em Estoque</th>
                                    <th class="border border-gray-200 px-4 py-2">Excluir</th>
                                    <th class="border border-gray-200 px-4 py-2">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td class="border border-gray-200 px-4 py-2">{{ product.name }}</td>
                                    <td
                                        class="border border-gray-200 px-4 py-2 text-nowrap overflow-hidden text-ellipsis max-w-[300px]">
                                        {{ product.description }}</td>
                                    <td class="border border-gray-200 px-4 py-2">R$ {{ product.price }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ product.stock_quantity }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <DangerButton @click="openModal(product.id, 'product')">Excluir
                                        </DangerButton>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <PrimaryButton @click="showProduct(product.id)">Ver</PrimaryButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[500px]">
                <h2 class="text-lg font-bold mb-4">Confirmação de Exclusão</h2>
                <p>Você tem certeza que deseja excluir o produto?</p>
                <div class="flex justify-end mt-4">
                    <DangerButton @click="deleteItem">Confirmar</DangerButton>
                    <button @click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
