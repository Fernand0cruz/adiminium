<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    name: '',
    description: '',
    price: '',
    stock_quantity: '',
    photo: null,
});
const successMessage = ref('');
const errorMessage = ref('');
const photoError = ref('');

const onPhotoInput = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.photo = file;
        photoError.value = '';
    }
};

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

const resetForm = () => {
    form.value.name = '';
    form.value.description = '';
    form.value.price = '';
    form.value.stock_quantity = '';
    form.value.photo = null;
    photoError.value = '';
};

const submit = async () => {
    if (!form.value.photo) {
        photoError.value = 'A foto do produto é obrigatória';
        return;
    }

    const rawPrice = form.value.price.replace(/[^0-9]/g, '');
    const numericPrice = rawPrice ? parseFloat(rawPrice) / 100 : 0;

    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('description', form.value.description);
    formData.append('price', numericPrice);
    formData.append('stock_quantity', form.value.stock_quantity);
    if (form.value.photo) {
        formData.append('photo', form.value.photo);
    }

    try {
        const response = await axios.post('/api/product', formData);
        if (response.data.success) {
            successMessage.value = response.data.success || 'Produto registrado com sucesso!';
            errorMessage.value = '';
            resetForm();
        } else {
            errorMessage.value = response.data.error || 'Ocorreu um erro ao registrar o pedido.';
            successMessage.value = '';
        }
    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Erro ao registrar produto';
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-5">Registrar Produto</h1>
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
                                <InputLabel for="name" value="Nome do produto" />
                                <TextInput id="name" name="name" type="text" class="mt-1 block w-full"
                                    v-model="form.name" required autofocus />
                            </div>

                            <div>
                                <InputLabel for="description" value="Descrição do produto" />
                                <TextArea id="description" name="description" class="mt-1 block w-full"
                                    v-model="form.description" />
                            </div>

                            <div class="flex gap-5">
                                <div class="w-1/2">
                                    <InputLabel for="price" value="Preço do produto" />
                                    <TextInput id="price" name="price" type="text" class="mt-1 block w-full"
                                        v-model="form.price" @input="handleInputChange" required />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel for="stock_quantity" value="Quantidade em estoque" />
                                    <TextInput id="stock_quantity" name="stock_quantity" type="text"
                                        class="mt-1 block w-full" v-model="form.stock_quantity"
                                        @input="handleInputChange" required />
                                </div>
                            </div>
                            <div>
                                <InputLabel for="photo" value="Foto do produto" />
                                <label for="photo" class="upload-label">
                                    <span>{{ form.photo ? form.photo.name : 'Clique ou arraste para soltar a imagem'
                                        }}</span>
                                    <input type="file" id="photo" accept="image/*" class="hidden"
                                        @change="onPhotoInput" />
                                </label>
                                <span v-if="photoError" class="text-red-500">{{ photoError }}</span>
                            </div>
                            <div>
                                <PrimaryButton type="submit">
                                    Registrar Produto
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #6366f1;
    border-radius: 5px;
    padding: 20px;
    cursor: pointer;
    transition: border-color 0.3s;
}

.upload-label:hover {
    border-color: #6366f1;
}

.upload-label span {
    color: #6c757d;
    font-weight: 600;
}

input[type="file"].hidden {
    display: none;
}
</style>
