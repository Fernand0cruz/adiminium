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
                    :href="route('register')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Se registrar
                </Link>

                <button type="submit"
                        class="ms-4 py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all text-sm">
                    Entrar
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/vue3";
import FormErrorInput from "@/Components/FormErrorInput.vue";
import FormEmailInput from "@/Components/FormEmailInput.vue";
import FormPasswordInput from "@/Components/FormPasswordInput.vue";
import FormLabel from "@/Components/FormLabel.vue";

const form = useForm({
    email: "",
    password: "",
});

const userFields = [
    { id: "email", label: "Email:", component: FormEmailInput, bindings: { id: "email" }},
    { id: "password", label: "Senha:", component: FormPasswordInput, bindings: { id: "password" }},
]

const submit = async () => {
    form.clearErrors();
    try {
        const response = await axios.post("login", form);
        if (response.data.status) {
            localStorage.setItem("auth_token", response.data.data.token);
            window.location.href = response.data.data.redirect_url;
        } else {
            form.setError("error", response.data.message);
        }
    } catch (error) {
        if (error.response) {
            if (error.response.data.errors) {
                for (const [key, messages] of Object.entries(
                    error.response.data.errors
                )) {
                    form.setError(key, messages[0]);
                }
            } else {
                form.setError("error", error.response.data.message);
            }
        } else {
            console.error("An unexpected error occurred:", error);
        }
    }
};
</script>
