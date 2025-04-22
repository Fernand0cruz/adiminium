<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div v-for="field in userFields" :key="field.id" class="grid sm:grid-cols-12 mt-4 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <FormLabel :for="field.id" :label="field.label" />
                </div>
                <div class="sm:col-span-9">
                    <template v-if="field.component">
                        <Component :is="field.component" v-bind="field.bindings" v-model="form[field.id]"
                                   :placeholder="field.placeholder" />
                    </template>
                    <FormErrorInput :message="form.errors[field.id]" />
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Ja possui conta?
                </Link>

                <button type="submit"
                        class="ms-4 py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all text-sm">
                        Registrar
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import FormErrorInput from "@/Components/FormErrorInput.vue";
import { Link, useForm } from "@inertiajs/vue3";
import axios from "axios";
import FormTextInput from "@/Components/FormTextInput.vue";
import FormEmailInput from "@/Components/FormEmailInput.vue";
import FormPhoneInput from "@/Components/FormPhoneInput.vue";
import FormPasswordInput from "@/Components/FormPasswordInput.vue";
import FormLabel from "@/Components/FormLabel.vue";

const form = useForm({
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
});

const userFields = [
    { id: "name", label: "Nome:", component: FormTextInput, bindings: { id: "name" }},
    { id: "email", label: "Email:", component: FormEmailInput, bindings: { id: "email" }},
    { id: "phone", label: "Telefone:", component: FormPhoneInput, bindings: { id: "phone" }},
    { id: "password", label: "Senha:", component: FormPasswordInput, bindings: { id: "password" }},
    { id: "password_confirmation", label: "Confirmar Senha:", component: FormPasswordInput, bindings: { id: "password_confirmation" }},
]

const submit = async () => {
    form.clearErrors();
    try {
        const response = await axios.post("register", form);
        if (response.data.status) {
            localStorage.setItem("auth_token", response.data.data.token);
            window.location.href = response.data.data.redirect_url;
        } else {
            form.setError("error", response.data.message);
        }
    } catch (error) {
        if (error.response) {
            if (error.response.data.errors) {
                Object.entries(error.response.data.errors).forEach(
                    ([key, messages]) => {
                        form.setError(key, messages[0]);
                    }
                );
            } else {
                form.setError("error", error.response.data.message);
            }
        } else {
            console.error("An unexpected error occurred:", error);
            form.setError(
                "error",
                "An unexpected error occurred. Please try again later."
            );
        }
    }
};
</script>
