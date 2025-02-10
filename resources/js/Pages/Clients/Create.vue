<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { createClient } from "@/Services/api";
import { useToast } from "vue-toastification";
import InputError from "@/Components/InputError.vue";
import { watch } from "vue";

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
        if(error.errors){
            Object.entries(error.errors).forEach(([key, messages]) => {
                form.setError(key, messages[0])
            })
        } else {
            toast.error(error.message);
        }
    }
};
const clearErrorOnChange = (field) => {
    watch(
        () => form[field],
        (newValue) => {
            if (newValue) {
                form.errors[field] = null;
            }
        }
    );
}

clearErrorOnChange('company')
clearErrorOnChange('name')
clearErrorOnChange('email')
clearErrorOnChange('phone')
clearErrorOnChange('password')
clearErrorOnChange('confirmPassword')

</script>

<template>
    <AuthenticatedLayout>
        <h1 class="font-semibold text-lg">Register Clients</h1>

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

                <InputError class="mt-2" :message="form.errors.company" />
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

                <InputError class="mt-2" :message="form.errors.name" />
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

                <InputError class="mt-2" :message="form.errors.email" />
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

                <InputError class="mt-2" :message="form.errors.phone" />
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

                    <InputError class="mt-2" :message="form.errors.password" />
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

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div>
                <PrimaryButton> Register Client </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>


