<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { onMounted, ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

// rever: apos authenticação da api ajustar controllador para fazer buscas no db de acordo com o user logado, no momento retorna tds os pedidos do sistema

const { props } = usePage();
const userId = props.auth.user.id;

const ordersOpen = ref([]);
const ordersPending = ref([]);

const successMessage = ref('');
const errorMessage = ref('');

const totalOrderValue = computed(() => {
    return ordersOpen.value.reduce((total, order) => {
        return total + order.product.price * order.quantity;
    }, 0);
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
};

onMounted(async () => await fetchOrders());

const fetchOrders = async () => {
    try {
        const response = await axios.get('/api/orders');
        ordersOpen.value = response.data.ordersOpen;
        ordersPending.value = response.data.ordersPending;
    } catch (error) {
        errorMessage.value = 'Erro ao carregar pedidos';
    }
};

const updateOrder = async (order) => {
    try {
        await axios.patch(`/api/order/${order.id}`, { quantity: order.quantity });
    } catch (error) {
        errorMessage.value = 'Erro ao atualizar o pedido.';
    }
};

const incrementQuantity = (order) => {
    if (order.quantity < order.product.stock_quantity) {
        order.quantity++;
        updateOrder(order);
    } else {
        errorMessage.value = 'Quantidade excede o estoque disponível.';
    }
};

const decrementQuantity = (order) => {
    if (order.quantity > 1) {
        order.quantity--;
        updateOrder(order);
    }
};

const deleteOrder = async (order) => {
    try {
        const response = await axios.delete(`/api/order/${order.id}`);
        if (response.data.success) {
            successMessage.value = response.data.success || 'Pedido excluído com sucesso!';
            ordersOpen.value = ordersOpen.value.filter(o => o.id !== order.id);
        } else {
            errorMessage.value = 'Erro inesperado ao excluir o pedido';
        }
    } catch (error) {
        errorMessage.value = 'Erro ao excluir o pedido.';
    }
};

const sendOrder = async () => {
    try {
        const response = await axios.post('/api/sendorder', {
            client_id: userId,
            order_data: ordersOpen.value,
            status: 'pending',
        })
        fetchOrders();
        if (response.data.success) {
            successMessage.value = response.data.success || 'Pedidos criado com sucesso!';
            errorMessage.value = '';
        } else {
            errorMessage.value = response.data.error || 'Ocorreu um erro ao criar o ser pedido.';
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
                    <div class="p-6 text-gray-900 flex flex-col gap-4">
                        <h1>Meus Pedidos</h1>
                        <div v-if="successMessage"
                            class="p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                            {{ successMessage }}
                        </div>
                        <div v-if="errorMessage"
                            class="p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                            {{ errorMessage }}
                        </div>
                        <div class="flex gap-1">
                            <h1>Pedido(s) aberto(s):</h1>
                            <span v-if="ordersOpen.length < 1">Nenhum pedido aberto no momento!</span>
                        </div>
                        <div v-if="ordersOpen.length > 0">
                            <div v-for="orderInProgress in ordersOpen" :key="orderInProgress.id"
                                class="bg-gray-100 rounded-md p-4 mb-1">
                                <div class="flex justify-between items-center mb-2">
                                    <h2 class="font-semibold text-lg">Produto: {{ orderInProgress.product.name }}</h2>
                                    <div>
                                        <span class="text-sm text-gray-600">Preço Unitário:</span>
                                        <span class="font-semibold">{{ formatCurrency(orderInProgress.product.price)
                                            }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <span>Quantidade:</span>
                                        <button @click="decrementQuantity(orderInProgress)"
                                            class="border rounded-md bg-white px-2">-</button>
                                        <span>{{ orderInProgress.quantity }}</span>
                                        <button @click="incrementQuantity(orderInProgress)"
                                            class="border rounded-md bg-white px-2">+</button>
                                        <button @click="deleteOrder(orderInProgress)"
                                            class="border rounded-md bg-white px-2">Excluir</button>
                                    </div>
                                    <div>
                                        <span>Total: </span>
                                        <span class="font-semibold">{{ formatCurrency(orderInProgress.product.price *
                                            orderInProgress.quantity) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <PrimaryButton @click="sendOrder">
                                    Enviar Pedido
                                </PrimaryButton>
                                <span>Total Geral: {{ formatCurrency(totalOrderValue) }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex gap-1">
                                <h1>Pedido(s) em andamento:</h1>
                                <span v-if="ordersPending < 1">Nenhum pedido em andamento no momento!</span>
                            </div>
                            <div v-for="ordersPending in ordersPending" :key="ordersPending.id">
                                {{ ordersPending.order_data }}
                            </div>
                        </div>
                        <div>
                            <div class="flex gap-1">
                                <h1>Pedido(s) concluido(s):</h1>
                                <span>Nenhum pedido concluido!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
