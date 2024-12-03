<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NumberInput from "@/Components/NumberInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { createProduct } from "@/Services/api";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/vue3";

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
        toast.error(error.message);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="font-semibold text-lg">Register Product</h1>

        <!-- TODO: componentizar form -->
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
            </div>

            <div>
                <InputLabel for="description" value="Product Description" />

                <TextArea
                    id="description"
                    name="description"
                    class="mt-1 block w-full"
                    v-model="form.description"
                />
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
