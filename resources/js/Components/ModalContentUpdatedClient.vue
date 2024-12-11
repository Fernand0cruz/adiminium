<script setup>
import PrimaryButton from './PrimaryButton.vue';
import DangerButton from './DangerButton.vue';
import TextInput from './TextInput.vue';
import InputLabel from './InputLabel.vue';
import InputError from './InputError.vue';
import { watch } from 'vue';

const props = defineProps({
    form: Object,
});

const emit = defineEmits(["closeModal", "submit"]);

const clearErrorOnChange = (field) => {
    watch(
        () => props.form[field],
        (newValue) => {
            if (newValue) {
                props.form.errors[field] = null;
            }
        }
    );
};

clearErrorOnChange('company');
clearErrorOnChange('name'); 
clearErrorOnChange('email');
clearErrorOnChange('phone');
clearErrorOnChange('password');
clearErrorOnChange('confirmPassword');
</script>

<template>
    <h2 class="font-semibold text-lg mb-4">Edit Client</h2>

    <!-- TODO: componentizar form -->
    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-6">
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

        <span class="text-red-600"
            >The password field is only required if you wish to change it.</span
        >

        <div class="flex gap-6">
            <div class="w-1/2">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="w-1/2">
                <InputLabel for="confirmPassword" value="Confirm Password" />

                <TextInput
                    id="confirmPassword"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
        </div>

        <div class="flex gap-6 justify-end">
            <PrimaryButton>Update Client</PrimaryButton>
            
            <DangerButton @click="$emit('closeModal')">Cancel</DangerButton>
        </div>
    </form>
</template>

<style scoped>
/* Your styles here */
</style>
