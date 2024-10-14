<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import axios from 'axios';

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

const handlePhoneInput = (event) => {
    phone.value = formatPhone(event.target.value);
};

const resetForm = () => {
    form.value.company = '';
    form.value.name = '';
    form.value.email = '';
    form.value.phone = '';
    form.value.password = '';
    form.value.password_confirmation = '';
};

const submit = async () => {
    const formData = new FormData();
    formData.append('company', form.value.company);
    formData.append('name', form.value.name);
    formData.append('email', form.value.email);
    formData.append('phone', form.value.phone);
    formData.append('password', form.value.password);
    formData.append('password_confirmation', form.value.password_confirmation);

    try {
        const token = localStorage.getItem('auth_token'); 
        if (!token) {
            errorMessage.value = 'Token de autenticação não encontrado, favor sair e entrar no sistema novamente.';
            return; 
        }
        
        const response = await axios.post('/api/client', formData, {
            headers: {
                Authorization: `Bearer ${token}` 
            }
        });
        if(response.data.success) {
            successMessage.value = response.data.success || 'Cliente registrado com sucesso!';
            resetForm();
        } else {
            errorMessage.value = 'Ocorreu um erro ao criar o cliente.';
            successMessage.value = '';
        }
    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Erro ao registrar cliente';
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-5">Registrar Clientes</h1>
                        <div v-if="successMessage"
                            class="my-4 p-4 text-center text-green-500 bg-green-100 rounded-md border border-green-600">
                            {{ successMessage }}
                        </div>
                        <div v-if="errorMessage"
                            class="my-4 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600">
                            {{ errorMessage }}
                        </div>
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
                            <div class="flex gap-5">
                                <div class="w-1/2">
                                    <InputLabel for="password" value="Senha" />
                                    <TextInput id="password" type="password" class="mt-1 block w-full"
                                        v-model="form.password" required />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel for="confirmPassword" value="Confirmar Senha" />
                                    <TextInput id="confirmPassword" type="password" class="mt-1 block w-full"
                                        v-model="form.password_confirmation" required />
                                </div>
                            </div>
                            <div>
                                <PrimaryButton>
                                    Registrar Cliente
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
