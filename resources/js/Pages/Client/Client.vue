<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// rever: inserir paginação
const client = ref({});
const isModalOpen = ref(false);

const form = ref({
    company: '',
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const successMessage = ref('');
const errorMessage = ref('');

// rever: procurar alguma biblioteca de mask
const formatPhone = (value) => {
    value = value.replace(/\D/g, '');
    if (value.length > 11) {
        value = value.slice(0, 11);
    }
    if (value.length > 2) {
        value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
    } else if (value.length === 2) {
        value = `(${value})`;
    }
    if (value.length > 9) {
        return value.replace(/(\(\d{2}\)) (\d{5})(\d{0,4})/, '$1 $2-$3');
    } else {
        return value;
    }
};

const handlePhoneInput = (event) => phone.value = formatPhone(event.target.value);

const getClientFromUrl = () => {
    const segments = window.location.pathname.split('/');
    return segments.length > 2 ? segments[segments.length - 1] : null;
};

onMounted(async () => await fetchClient());

const fetchClient = async () => {
    const id = getClientFromUrl();
    const response = await axios.get(`/api/client/${id}`);
    client.value = response.data.client;
};

const openModal = (client) => {
    isModalOpen.value = true;
    form.value.company = client.company
    form.value.name = client.name
    form.value.email = client.email
    form.value.phone = client.phone
};

const closeModal = () => isModalOpen.value = false;


const submit = async () => {
    const formData = new FormData();
    formData.append('company', form.value.company);
    formData.append('name', form.value.name);
    formData.append('email', form.value.email);
    formData.append('phone', form.value.phone);
    formData.append('password', form.value.password);

    if (password.value) {
        formData.append('password', form.value.password);
        formData.append('password_confirmation', form.value.password_confirmation);
    }

    try {
        const response = await axios.patch(`/api/client/${client.value.id}`, Object.fromEntries(formData.entries()));
        if (response.data.success) {
            successMessage.value = response.data.success || 'Produto atualizado com sucesso!';
            closeModal();
            fetchClient();
        } else {
            errorMessage.value = 'Erro inesperado ao atualizar o cliente';
        }
        
    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Erro ao atualizar cliente';
    }
}
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
                    <div class="p-6 text-gray-900">
                        <div class="w-full bg-gray-100 rounded-md p-8 flex flex-col gap-4">
                            <h1>Cliente - {{ client.name }}</h1>
                            <h2 class="text-xl font-bold">{{ client.name }}</h2>
                            <p><strong>Empresa:</strong> {{ client.company }}</p>
                            <p><strong>Email:</strong> {{ client.email }}</p>
                            <p><strong>Telefone:</strong> {{ client.phone }}</p>
                            <div>
                                <PrimaryButton @click=openModal(client)>Editar Cliente</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Rever: acho q ao invez de abrir um popup para edição cria uma sessão abaixo do user ficaria melhor -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[750px]">
                <h2 class="text-lg font-bold mb-4">Editar Produto</h2>
                <form @submit.prevent="submit" class="flex flex-col gap-5">
                    <div>
                        <InputLabel for="company" value="Nome da Empresa" />
                        <TextInput id="company" type="text" class="mt-1 block w-full" v-model="form.company" required
                            autofocus />
                    </div>
                    <div>
                        <InputLabel for="name" value="Nome do Responsável" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                    </div>
                    <div>
                        <InputLabel for="email" value="E-mail" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                    </div>
                    <div>
                        <InputLabel for="phone" value="Telefone" />
                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                            @input="handlePhoneInput" required />
                    </div>
                    <span class=" text-red-600">Só é necessario preencher o campo de senha caso deseje alterar.</span>
                    <div class="flex gap-5">
                        <div class="w-1/2">
                            <InputLabel for="password" value="Senha" />
                            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="confirmPassword" value="Confirmar Senha" />
                            <TextInput id="confirmPassword" type="password" class="mt-1 block w-full"
                                v-model="form.password_confirmation" />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton>
                            Atualizar Cliente
                        </PrimaryButton>
                        <button @click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>