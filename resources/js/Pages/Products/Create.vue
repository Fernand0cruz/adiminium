<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NumberInput from "@/Components/NumberInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import { createProduct } from "@/Services/api";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const toast = useToast();

const form = useForm({
    name: "",
    description: "",
    price: "1",
    stock_quantity: 1,
    photo: null,
});

const onPhotoInput = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.photo = file;
    }
};

const submit = async () => {
    try {
        form.price = parseFloat(
            form.price.replace(/[R$.\s]/g, "").replace(",", ".")
        ).toString();

        const formData = new FormData();
        for (const key in form) {
            formData.append(key, form[key]);
        }

        const response = await createProduct(formData);
        form.reset();
        toast.success(response);
    } catch (error) {
        if (error.errors) {
            Object.entries(error.errors).forEach(([key, messages]) => {
                form.setError(key, messages[0]);
            });
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
};

clearErrorOnChange("name");
clearErrorOnChange("description");
clearErrorOnChange("price");
clearErrorOnChange("stock_quantity");
clearErrorOnChange("photo");
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="font-semibold text-lg">Register Product</h1>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div>
                <InputLabel for="name" value="Product Name" />

                <TextInput
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="description" value="Product Description" />

                <TextArea
                    id="description"
                    name="description"
                    class="mt-1 block w-full"
                    v-model="form.description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="flex gap-6">
                <div class="w-1/2">
                    <InputLabel for="price" value="Product Price" />

                    <TextInput
                        id="price"
                        name="price"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.price"
                        v-mask="[
                            'R$ #,##',
                            'R$ ##,##',
                            'R$ ###,##',
                            'R$ ####,##',
                            'R$ #####,##',
                        ]"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div class="w-1/2">
                    <InputLabel for="stock_quantity" value="Stock Quantity" />

                    <NumberInput
                        id="stock_quantity"
                        class="mt-1 block w-full"
                        v-model="form.stock_quantity"
                        v-mask="'####'"
                        required
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.stock_quantity"
                    />
                </div>
            </div>

            <div>
                <InputLabel for="photo" value="Product Photo" />

                <label for="photo" class="upload-label">
                    <span>{{
                        form.photo
                            ? form.photo.name
                            : "Click or drag to drop the image"
                    }}</span>

                    <input
                        type="file"
                        id="photo"
                        accept="image/*"
                        class="hidden"
                        @change="onPhotoInput"
                    />
                </label>

                <InputError class="mt-2" :message="form.errors.photo" />
            </div>

            <div>
                <PrimaryButton type="submit"> Register Product </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<style scoped>
.upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #6366f1;
    border-radius: 5px;
    padding: 20px;
    cursor: pointer;
    transition: border-color 0.3s;
}

.upload-label:hover {
    border-color: #6366f1;
}

.upload-label span {
    color: #6c757d;
    font-weight: 600;
}

input[type="file"].hidden {
    display: none;
}
</style>
