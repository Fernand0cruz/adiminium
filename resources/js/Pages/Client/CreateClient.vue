<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { createClient } from "@/Services/api";
import { useToast } from "vue-toastification";

const toast = useToast();

const form = useForm({
    company: "",
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
});

const submit = async () => {
    try {
        const response = await createClient(form);
        form.reset();
        toast.success(response);
    } catch (error) {
        toast.error(error.message);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="font-semibold text-lg">Register Clients</h1>

        <!-- TODO: componentizar form -->
        <form @submit.prevent="submit" class="flex flex-col gap-6">
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
            </div>

            <div>
                <InputLabel for="name" value="Responsible Person's Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />
            </div>

            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    v-mask="'(##) #####-####'"
                    required
                />
            </div>

            <div class="flex gap-6">
                <div class="w-1/2">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                    />
                </div>

                <div class="w-1/2">
                    <InputLabel
                        for="confirmPassword"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="confirmPassword"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                    />
                </div>
            </div>

            <div>
                <PrimaryButton> Register Client </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
