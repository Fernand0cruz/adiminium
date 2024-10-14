<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const product = ref({});
const isModalOpen = ref(false);

const form = ref({
    name: '',
    description: '',
    price: '',
    stock_quantity: '1',
});

const successMessage = ref('');
const errorMessage = ref('');

const { props } = usePage();
const userRole = props.auth.user.role;

const getProductIdFromUrl = () => {
    const segments = window.location.pathname.split('/');
    return segments.length > 1 ? segments[segments.length - 1] : null;
};

onMounted(async () => await fetchProduct());

const fetchProduct = async () => {
    try {
        const id = getProductIdFromUrl();
        const token = localStorage.getItem('auth_token');
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return;
        }

        const response = await axios.get(`/api/product/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        product.value = response.data.product;
    } catch (error) {
        errorMessage.value = 'Erro ao carregar produto';
    }
};

const getProductPhotoUrl = (photoPath) => photoPath.startsWith('http') ? photoPath : `/storage/${photoPath}`

const makeOrder = async () => {
    try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return;
        }

        const response = await axios.post('/api/order', {
            client_id: props.auth.user.id,
            product_id: product.value.id,
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

const openModal = (product) => {
    isModalOpen.value = true;
    form.value.name = product.name
    form.value.description = product.description
    form.value.price = formatPrice(product.price.toString());
    form.value.stock_quantity = product.stock_quantity.toString();
    errorMessage.value = '';
    successMessage.value = '';
}

const closeModal = () => {
    isModalOpen.value = false;
    errorMessage.value = '';
}

const formatPrice = (value) => {
    const cleaned = value.replace(/\D/g, '');
    return cleaned.length === 0 ? '' : (parseInt(cleaned) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};

//rever
const handleInputChange = (event) => {
    const { name, value } = event.target;

    const cleanedValue = value.replace(/\D/g, '');
    const numericValue = parseInt(cleanedValue, 10);

    if (name === 'price') {
        if (numericValue < 1) {
            form.value.price = formatPrice('1');
            errorMessage.value = 'O valor mínimo para o preço é R$ 0,01.';
        } else if (numericValue > 1000000) {
            form.value.price = formatPrice('1000000');
            errorMessage.value = 'O valor máximo para o preço é R$ 10.000,00.';
        } else {
            form.value.price = formatPrice(cleanedValue);
            errorMessage.value = '';
        }
    } else if (name === 'stock_quantity') {
        if (numericValue <= 0) {
            form.value.stock_quantity = '1';
            errorMessage.value = 'A quantidade de produtos para o estoque deve ser maior que zero.';
        } else if (numericValue > 500) {
            form.value.stock_quantity = '500';
            errorMessage.value = 'Quantidade para estoque deve ser de no maximo 500.';
        } else {
            form.value.stock_quantity = cleanedValue;
            errorMessage.value = '';
        }
    }
}

//rever
const handleStockQuantityInput = (event) => {
    const cleaned = event.target.value.replace(/\D/g, '');
    const numericValue = parseInt(cleaned, 10);

    if (product.value) {
        if (numericValue <= 0) {
            form.value.stock_quantity = '1';
            errorMessage.value = 'A quantidade deve ser maior que zero.';
        } else if (numericValue > product.value.stock_quantity) {
            form.value.stock_quantity = product.value.stock_quantity.toString();
            errorMessage.value = `Quantidade disponivel ${product.value.stock_quantity}.`;
        } else {
            form.value.stock_quantity = cleaned;
            errorMessage.value = '';
        }
    }
};

const submit = async () => {
    const rawPrice = form.value.price.replace(/[^0-9]/g, '');
    const numericPrice = rawPrice ? parseFloat(rawPrice) / 100 : 0;

    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('description', form.value.description);
    formData.append('price', numericPrice);
    formData.append('stock_quantity', form.value.stock_quantity);

    try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return;
        }
        const response = await axios.patch(`/api/product/${product.value.id}`,
            Object.fromEntries(formData.entries()),
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        if (response.data.success) {
            successMessage.value = response.data.success || 'Produto atualizado com sucesso!';
            closeModal();
            fetchProduct();
        } else {
            errorMessage.value = 'Erro inesperado ao atualizar o produto';
        }

    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Erro ao atualiza produto';
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="successMessage"
                        class="mt-6 mx-6 p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                        {{ successMessage }}
                    </div>
                    <div v-if="errorMessage"
                        class="mt-6 mx-6 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                        {{ errorMessage }}
                    </div>
                    <div class="p-6 text-gray-900 flex w-full">
                        <div class="w-1/2 flex justify-center items-center">
                            <img class="max-h-[400px]" v-if="product.photo" :src="getProductPhotoUrl(product.photo)"
                                alt="Imagem do produto" />
                        </div>
                        <div class="w-1/2 bg-gray-100 rounded-md p-8 flex flex-col gap-4">
                            <h1>Produto - {{ product.name }}</h1>
                            <h2 class="text-xl font-bold">{{ product.name }}</h2>
                            <p><strong>Descrição:</strong> {{ product.description }}</p>
                            <p><strong>Preço:</strong> R$ {{ product.price }}</p>
                            <p><strong>Quantidade em Estoque:</strong> {{ product.stock_quantity }}</p>
                            <div v-if="userRole === 'client'" class="flex items-end">
                                <div class="flex flex-col w-full">
                                    <InputLabel for="stock_quantity" value="Quantidade no pedido" />
                                    <TextInput id="stock_quantity" type="text" class="mt-1 block w-full"
                                        v-model="form.stock_quantity" @input="handleStockQuantityInput"
                                        :max="product.stock_quantity" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <PrimaryButton v-if="userRole === 'client'" @click="makeOrder">Fazer Pedido
                                </PrimaryButton>
                                <PrimaryButton v-if="userRole === 'admin'" @click=openModal(product)>Editar Produto
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Rever: acho q ao invez de abrir um popup para edição cria uma sessão abaixo do produto ficaria melhor -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[750px]">
                <h2 class="text-lg font-bold mb-4">Editar Produto</h2>
                <div v-if="errorMessage"
                    class="p-4 mb-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-5">
                    <div>
                        <InputLabel for="name" value="Nome do produto" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            autofocus />
                    </div>
                    <div>
                        <InputLabel for="description" value="Descrição do produto" />
                        <TextArea class="mt-1 block w-full" v-model="form.description" />
                    </div>
                    <div class="flex gap-5">
                        <div class="w-1/2">
                            <InputLabel for="price" value="Preço do produto" />
                            <TextInput id="price" name="price" type="text" class="mt-1 block w-full"
                                v-model="form.price" @input="handleInputChange" required />
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="stock_quantity" value="Quantidade em estoque" />
                            <TextInput id="stock_quantity" name="stock_quantity" type="text" class="mt-1 block w-full"
                                v-model="form.stock_quantity" @input="handleInputChange" required />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton>
                            Atualizar Produto
                        </PrimaryButton>
                        <button @click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
