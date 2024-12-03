<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
});

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

<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div className="error-message">{{ form.errors.error }}</div>

            <div>
                <InputLabel for="email" value="E-mail" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.email" />
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

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('register')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Register
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
