<script setup>
import InputLabel from "./InputLabel.vue";
import TextInput from "./TextInput.vue";
import TextArea from "./TextArea.vue";
import NumberInput from "./NumberInput.vue";
import PrimaryButton from "./PrimaryButton.vue";
import DangerButton from "./DangerButton.vue";

const props = defineProps({
    form: Object,
});

const emit = defineEmits(["closeModal", "submit"]);
</script>

<template>
    <h2 class="font-semibold text-lg mb-4">Edit Product</h2>

    <!-- TODO: componentizar form -->
    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-6">
        <div>
            <InputLabel for="name" value="Product Name" />

            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
            />
        </div>

        <div>
            <InputLabel for="description" value="Product Description" />

            <TextArea class="mt-1 block w-full" v-model="form.description" />
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

        <div class="flex gap-6 justify-end">
            <PrimaryButton>Update Product</PrimaryButton>
            
            <DangerButton @click="$emit('closeModal')">Cancel</DangerButton>
        </div>
    </form>
</template>

<style scoped>
/* Your styles here */
</style>
