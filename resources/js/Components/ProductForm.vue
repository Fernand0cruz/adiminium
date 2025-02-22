<template>
    <!-- ERROR MESSAGE -->
    <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

    <form @submit.prevent="createProduct">
        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
            <!-- PHOTO PRODUCT -->
            <div class="sm:col-span-3">
                <FormLabel for="photo" label="Foto do Produto:" />
            </div>
            <div class="sm:col-span-9">
                <FormPhotoUpload
                    :key="form.photo"
                    id="photo"
                    v-model="form.photo"
                    placeholderImage="/images/placeholder-product.png"
                />
                <FormErrorInput :message="formErrors.photo?.[0]" />
            </div>

            <!-- NAME PRODUCT -->
            <div class="sm:col-span-3">
                <FormLabel for="name" label="Nome do Produto:" />
            </div>
            <div class="sm:col-span-9">
                <FormTextInput
                    id="name"
                    v-model="form.name"
                    placeholder="Informe o nome do produto..."
                />
                <FormErrorInput :message="formErrors.name?.[0]" />
            </div>

            <!-- DESCRIPTION PRODUCT -->
            <div class="sm:col-span-3">
                <FormLabel for="description" label="Descrição do produto:" />
            </div>
            <div class="sm:col-span-9">
                <FormTextArea
                    id="description"
                    v-model="form.description"
                    placeholder="Informe uma descrição detalhada do produto..."
                />
                <FormErrorInput :message="formErrors.description?.[0]" />
            </div>

            <!-- PRICE PRODUCT -->
            <div class="sm:col-span-3">
                <FormLabel for="price" label="Preço:" />
            </div>
            <div class="sm:col-span-9">
                <FormCurrencyInput
                    id="price"
                    v-model="form.price"
                    placeholder="Informe o preço do produto(ex:R$ 100,00)..."
                />
                <FormErrorInput :message="formErrors.price?.[0]" />
            </div>

            <!-- PRODUCT DISCOUNT -->
            <div class="sm:col-span-3">
                <div class="inline-block">
                    <FormLabel for="discount" label="Desconto:" />
                    <span class="text-sm text-gray-400"
                        >(Em porcentagem %)</span
                    >
                </div>
            </div>
            <div class="sm:col-span-9">
                <FormPercentInput
                    id="discount"
                    v-model="form.discount"
                    placeholder="Informe a % de desconto(ex:10.00 para 10%)..."
                />
                <FormErrorInput :message="formErrors.discount?.[0]" />
            </div>

            <!-- QUANTITY OF PRODUCT IN STOCK -->
            <div class="sm:col-span-3">
                <FormLabel for="quantity" label="Quantidade em estoque:" />
            </div>
            <div class="sm:col-span-9">
                <FormNumberInput
                    id="quantity"
                    v-model="form.quantity"
                    placeholder="Informe a quantidade disponível em estoque..."
                />
                <FormErrorInput :message="formErrors.quantity?.[0]" />
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-x-4">
            <button
                type="button"
                @click="resetForm"
                class="py-[5px] px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm"
            >
                Limpar formulário
            </button>
            <button
                type="submit"
                class="py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all text-sm"
            >
                Criar Produto
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref } from "vue";
import { clearForm } from "@/Utils/clearForm";
import FormLabel from "./FormLabel.vue";
import FormTextInput from "./FormTextInput.vue";
import FormTextArea from "./FormTextArea.vue";
import FormCurrencyInput from "./FormCurrencyInput.vue";
import FormPercentInput from "./FormPercentInput.vue";
import FormNumberInput from "./FormNumberInput.vue";
import FormPhotoUpload from "./FormPhotoUpload.vue";
import Services from "@/Services";
import ErrorMessage from "./ErrorMessage.vue";
import { useToast } from "vue-toastification";
import FormErrorInput from "./FormErrorInput.vue";

const errorMessage = ref(null);
const toast = useToast();
const formErrors = ref({});

const form = ref({
    photo: null,
    name: "",
    description: "",
    price: "",
    discount: "",
    quantity: "",
});

const resetForm = () => {
    clearForm(form, { photo: null });
};

const createProduct = async () => {
    try {
        formErrors.value = {};
        const response = await Services.products.create(form.value);
        toast.success(response.message);
        resetForm();
    } catch (error) {
        if (error) {
            formErrors.value = error;
        } 
        errorMessage.value = error.message?.[0]
    }
};
</script>
