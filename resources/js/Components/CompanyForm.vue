<template>
     <!-- ERROR MESSAGE -->
     <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

     <form v-if="!isEditing || company.id" @submit.prevent="createOrUpdateCompany">
        <h3 class="mt-4 pt-2 font-semibold border-t">Dados da empresa:</h3>
        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
                <FormLabel for="photo" label="Logo da empresa:" />
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
            v-for="field in companyFields"
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

        <h3 class="mt-4 pt-2 font-semibold border-t">Endereço da empresa:</h3>

        <div
            v-for="field in companyAddressFields"
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
                {{ isEditing ? "Atualizar Empresa" : "Criar Empresa" }}
            </button>
        </div>
     </form>
</template>

<script setup>
import { ref } from "vue";
import FormLabel from "./FormLabel.vue";
import { clearForm } from "@/Utils/clearForm";
import FormTextInput from "./FormTextInput.vue";
import FormCnpjInput from "./FormCnpjInput.vue";
import FormPhoneInput from "./FormPhoneInput.vue";
import FormNumberInput from "./FormNumberInput.vue";
import FormCepInput from "./FormCepInput.vue"
import FormErrorInput from "./FormErrorInput.vue";
import ErrorMessage from "./ErrorMessage.vue";
import FormPhotoUpload from "./FormPhotoUpload.vue";
import { useToast } from "vue-toastification";
import Services from "@/Services";

const isEditing = ref(false);
const errorMessage = ref(null);
const formErrors = ref({});
const toast = useToast();

const form = ref({
    photo: null,
    cnpj: "",
    business_name: "",
    phone: "",
    address: "",
    street: "",
    neighborhood: "",
    state: "",
    number: "",
    city: "",
    zip_code: ""
});

const companyFields = [
    { id: "cnpj", label: "CNPJ:", component: FormCnpjInput, bindings: { id: "cnpj" }, placeholder: "Informe o CNPJ da empresa..." },
    { id: "business_name", label: "Razão social:", component: FormTextInput, bindings: { id: "business_name" }, placeholder: "Informe a razão social da empresa..." },
    { id: "phone", label: "Telefone:", component: FormPhoneInput, bindings: { id: "phone" }, placeholder: "Informe o telefone da empresa..." },
];

const companyAddressFields = [
    { id: "address", label: "Endereço:", component: FormTextInput, bindings: { id: "address" }, placeholder: "Informe o endereço da empresa..." },
    { id: "street", label: "Logradouro:", component: FormTextInput, bindings: { id: "street" }, placeholder: "Informe o logradouro da empresa..." },
    { id: "neighborhood", label: "Bairro:", component: FormTextInput, bindings: { id: "neighborhood" }, placeholder: "Informe o bairro da empresa..." },
    { id: "state", label: "UF:", component: FormTextInput, bindings: { id: "state" }, placeholder: "Informe a UF da empresa..." },
    { id: "number", label: "Número:", component: FormNumberInput, bindings: { id: "number" }, placeholder: "Informe o número da empresa..." },
    { id: "city", label: "Município:", component: FormTextInput, bindings: { id: "city" }, placeholder: "Informe o município da empresa..." },
    { id: "zip_code", label: "CEP:", component: FormCepInput, bindings: { id: "zip_code" }, placeholder: "Informe o CEP da empresa..." },
];

const resetForm = () => {
    clearForm(form, { photo: null });
};

const createOrUpdateCompany = async () => {
    try {
        formErrors.value = {};
        const response = isEditing.value
            ? await Services.companies.update(form.value.id, form.value)
            : await Services.companies.create(form.value);

        toast.success(response.message);
        setTimeout(() => {
            window.location.href = `/companies/${
                isEditing.value ? form.value.id : response.data.id
            }`;
        }, 2500);
    } catch (error) {
        formErrors.value = error;
        errorMessage.value = error.message?.[0];
    }
};
</script>