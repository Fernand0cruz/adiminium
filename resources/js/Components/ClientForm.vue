<template>
    <!-- ERROR MESSAGE -->
    <ErrorMessage v-if="errorMessage" :errorMessage="errorMessage" />

    <form v-if="!isEditing || user.id" @submit.prevent="createOrUpdateClients">
        <h3 class="mt-4 pt-2 font-semibold border-t">Dados do cliente:</h3>
        <div v-if="!isEditing" class="grid sm:grid-cols-12 mt-4 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
                <FormLabel for="company_id" label="Empresa:" />
            </div>
            <div class="sm:col-span-9">
                <select v-model="form.company_id" id="company_id"
                    class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="" disabled class=" bg-gray-300">Selecione uma empresa para vincular o cliente
                    </option>
                    <option v-for="company in companiesUnsign.data" :key="company.id" :value="company.id">
                        {{ company.business_name }}
                    </option>
                </select>
                <FormErrorInput :message="formErrors.company_id?.[0]" />
            </div>
        </div>

        <div v-for="field in clientsFields" :key="field.id" class="grid sm:grid-cols-12 mt-4 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
                <FormLabel :for="field.id" :label="field.label" />
            </div>
            <div class="sm:col-span-9">
                <template v-if="field.component">
                    <Component :is="field.component" v-bind="field.bindings" v-model="form[field.id]"
                        :placeholder="field.placeholder" />
                </template>
                <template v-else-if="field.type === 'select'">
                    <select v-model="form[field.id]" class="w-full p-2 border rounded">
                        <option value="">Selecione uma empresa...</option>
                        <option v-for="company in companiesUnsign.data" :key="company.id" :value="company.id">
                            {{ company.name }}
                        </option>
                    </select>
                </template>
                <FormErrorInput :message="formErrors[field.id]?.[0]" />
            </div>
        </div>

        <h3 v-if="isEditing" class="mt-4 pt-2 font-semibold border-t">Preencha os campos abaixo somente se for trocar a
            senha:
        </h3>

        <div v-for="field in passwordFilds" :key="field.id" class="grid sm:grid-cols-12 mt-4 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
                <FormLabel :for="field.id" :label="field.label" />
            </div>
            <div class="sm:col-span-9">
                <template v-if="field.component">
                    <Component :is="field.component" v-bind="field.bindings" v-model="form[field.id]"
                        :placeholder="field.placeholder" />
                </template>
                <template v-else-if="field.type === 'select'">
                    <select v-model="form[field.id]" class="w-full p-2 border rounded">
                        <option value="">Selecione uma empresa...</option>
                        <option v-for="company in companiesUnsign.data" :key="company.id" :value="company.id">
                            {{ company.name }}
                        </option>
                    </select>
                </template>
                <FormErrorInput :message="formErrors[field.id]?.[0]" />
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-x-4">
            <button v-if="!isEditing" type="button" @click="resetForm"
                class="py-[5px] px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm">
                Limpar formulário
            </button>
            <button type="submit"
                class="py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all text-sm">
                {{ isEditing ? "Atualizar Cliente" : "Criar Cliente" }}
            </button>
        </div>
    </form>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import FormLabel from "./FormLabel.vue";
import {clearForm} from "@/Utils/clearForm";
import FormTextInput from "./FormTextInput.vue";
import FormPhoneInput from "./FormPhoneInput.vue";
import FormEmailInput from "./FormEmailInput.vue";
import FormErrorInput from "./FormErrorInput.vue";
import ErrorMessage from "./ErrorMessage.vue";
import {useToast} from "vue-toastification";
import Services from "@/Services/api/index.js";
import FormPasswordInput from "./FormPasswordInput.vue";

const props = defineProps({
    user: Object,
    errorMessage: String,
});

const isEditing = ref(false);
const errorMessage = ref(null);
const formErrors = ref({});
const toast = useToast();
const companiesUnsign = ref({});

const form = ref({
    company_id: "",
    name: "",
    email: "",
    phone: null,
    password: "",
    password_confirmation: ""
});

const clientsFields = [
    { id: "name", label: "Nome:", component: FormTextInput, bindings: { id: "name" }, placeholder: "Informe o nome do cliente..." },
    { id: "email", label: "Email:", component: FormEmailInput, bindings: { id: "email" }, placeholder: "Informe o email do cliente..." },
    { id: "phone", label: "Telefone:", component: FormPhoneInput, bindings: { id: "phone" }, placeholder: "Informe o telefone do cliente..." },
];

const passwordFilds = [
    { id: "password", label: "Senha:", component: FormPasswordInput, bindings: { id: "password" }, placeholder: "Informe uma senha para o cliente..." },
    { id: "password_confirmation", label: "Confirmar Senha:", component: FormPasswordInput, bindings: { id: "password_confirmation" }, placeholder: "Confirme a senha do cliente..." },
]

watch(
    () => props.user,
    (newUser) => {
        if (newUser) {
            form.value = { ...newUser, id: newUser.id ?? null }
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
    clearForm(form, { phone: null });
};

const createOrUpdateClients = async () => {
    try {
        formErrors.value = {};
        const response = isEditing.value
            ? await Services.clients.update(form.value.id, form.value)
            : await Services.clients.create(form.value);

        toast.success(response.message);
        setTimeout(() => {
            window.location.href = `/admin/clients/${isEditing.value ? form.value.id : response.data.id}`;
        }, 2500);
    } catch (error) {
        formErrors.value = error;
        errorMessage.value = error.message?.[0];
    }
};

const loadCompanies = async () => {
    try {
        companiesUnsign.value = await Services.companies.getCompaniesWithoutUsers();
    } catch (error) {
        console.log(error);
    }
};

onMounted(loadCompanies);
</script>
