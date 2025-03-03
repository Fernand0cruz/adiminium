<template>
    <!-- ERROR MESSAGE -->
    <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

    <form v-if="!isEditing || product.id" @submit.prevent="createOrUpdateProduct">
        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
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
        </div>
        <div
            v-for="field in fields"
            class="grid sm:grid-cols-12 mt-4 gap-2 sm:gap-6"
        >
            <div class="sm:col-span-3">
                <FormLabel :for="field.id" :label="field.label" />
            </div>
            <div class="sm:col-span-9">
                <Component
                    :is="field.component"
                    v-bind="field.bindings"
                    v-model="form[field.id]"
                    :placeholder="field.placeholder"
                />
                <FormErrorInput :message="formErrors[field.id]?.[0]" />
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-x-4">
            <button
                v-if="!isEditing"
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
                {{ isEditing ? "Atualizar Produto" : "Criar Produto" }}
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, watch } from "vue";
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

const props = defineProps({
    product: Object,
    errorMessage: String,
});

const errorMessage = ref(null);
const toast = useToast();
const formErrors = ref({});
const isEditing = ref(false);

const form = ref({
    photo: null,
    name: "",
    description: "",
    price: "",
    discount: "",
    quantity: "",
});

const fields = [
    {id: "name",label: "Nome do Produto:",component: FormTextInput,bindings: { id: "name" },placeholder: "Informe o nome do produto...",},
    {id: "description",label: "Descrição do Produto:",component: FormTextArea,bindings: { id: "description" },placeholder: "Informe uma descrição detalhada do produto...",},
    {id: "price",label: "Preço:",component: FormCurrencyInput,bindings: { id: "price" },placeholder: "Informe o preço do produto(ex:R$ 100,00)...",},
    {id: "discount",label: "Desconto:(Em porcentagem %)",component: FormPercentInput,bindings: { id: "discount" },placeholder: "Informe a % de desconto(ex:10.00 para 10%)...",},
    {id: "quantity",label: "Quantidade em estoque:",component: FormNumberInput,bindings: { id: "quantity" },placeholder: "Informe a quantidade disponível em estoque...",},
];

watch(
    () => props.product,
    (newProduct) => {
        if (newProduct) {
            form.value = { ...newProduct, id: newProduct.id ?? null };
            isEditing.value = true;
        }
    },
    { immediate: true }
);

watch(
    () => props.errorMessage,
    (newError) => {
        if (newError) {
            errorMessage.value = props.errorMessage;
        }
    },
    { immediate: true }
);

const resetForm = () => {
    clearForm(form, { photo: null });
};

const createOrUpdateProduct = async () => {
    try {
        formErrors.value = {};
        const response = isEditing.value
            ? await Services.products.update(form.value.id, form.value)
            : await Services.products.create(form.value);

        toast.success(response.message);
        setTimeout(() => {
            window.location.href = `/products/${
                isEditing.value ? form.value.id : response.data.id
            }`;
        }, 2500);
    } catch (error) {
        formErrors.value = error;
        errorMessage.value = error.message?.[0];
    }
};
</script>
