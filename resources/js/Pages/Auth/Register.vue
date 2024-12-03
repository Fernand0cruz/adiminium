<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";
import axios from "axios";

const form = useForm({
    company: "",
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
});

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

<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div
                v-if="form.errors.error"
                class="mb-4 mt-2 p-4 text-center text-red-600 bg-red-100 rounded-md border border-red-600"
            >
                {{ form.errors.error }}
            </div>

            <div>
                <InputLabel for="company" value="Company Name" />
                <TextInput
                    id="company"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.company" />
            </div>

            <div class="mt-4">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="E-mail" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone" />
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    v-mask="'(##) #####-####'"
                    required
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Comfirm Password"
                />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already have an account? Log in
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
