<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const clients = ref([]);
const successMessage = ref('');
const errorMessage = ref('');
const isModalOpen = ref(false);
const itemToDelete = ref(null);

onMounted(async () => {
    await fetchClients();
});

const fetchClients = async () => {
    try {
        const response = await axios.get('/api/clients');
        clients.value = response.data.clients;
    } catch (error) {
        errorMessage.value = 'Erro ao carregar clientes';
    }
};

const deleteItem = async () => {
    if (!itemToDelete.value) return;
    try {
        const response = await axios.delete(`/api/client/${itemToDelete.value}`);
        if (response.data.success) {
            successMessage.value = response.data.success || 'Cliente excluído com sucesso!';
            closeModal();
            fetchClients();
        } else {
            errorMessage.value = 'Erro inesperado ao excluir o produto';
        }
    } catch (error) {
        errorMessage.value = 'Erro ao excluir cliente.';
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

const showClient = (id) => window.location.href = `/client/${id}`;
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-5">Cliente no Sistema</h1>
                        <div v-if="successMessage"
                            class="mb-4 p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                            {{ successMessage }}
                        </div>
                        <div v-if="errorMessage"
                            class="m-4 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                            {{ errorMessage }}
                        </div>
                        <h1 v-if="(clients.length === 0)">Não há clientes para exibir. Cadastre um cliente!</h1>
                        <table v-if="(clients.length > 0)" class="min-w-full border-collapse border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Empresa</th>
                                    <th class="border border-gray-200 px-4 py-2">Nome</th>
                                    <th class="border border-gray-200 px-4 py-2">Email</th>
                                    <th class="border border-gray-200 px-4 py-2">Telefone</th>
                                    <th class="border border-gray-200 px-4 py-2">Excluir</th>
                                    <th class="border border-gray-200 px-4 py-2">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="client in clients" :key="client.id">
                                    <td class="border border-gray-200 px-4 py-2">{{ client.company }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ client.name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ client.email }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ client.phone }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <DangerButton @click="openModal(client.id, 'client')">Excluir
                                        </DangerButton>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <PrimaryButton @click="showClient(client.id)">Ver</PrimaryButton>
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
                <p>Você tem certeza que deseja excluir este cliente?</p>
                <div class="flex justify-end mt-4">
                    <DangerButton @click="deleteItem">Confirmar</DangerButton>
                    <button @click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
