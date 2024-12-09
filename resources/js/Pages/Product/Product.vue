<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import ProductDetails from "@/Components/ProductDetails.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import ModalContentUpdatedProduct from "@/Components/ModalContentUpdatedProduct.vue";
import { onMounted, ref } from "vue";
import { fetchProduct, createOrder, updateProduct } from "@/Services/api";
import { useToast } from "vue-toastification";
import { usePage, useForm } from "@inertiajs/vue3";

const product = ref({});
const isLoading = ref(false);
const toast = useToast();
const { props } = usePage();
const userRole = props.auth.user.role;
const isModalOpen = ref(false);

const form = useForm({
    name: "",
    description: "",
    price: "1",
    orderQuantity: 1,
    stock_quantity: 1,
});

const getProductIdFromUrl = () => {
    const urlSegments = window.location.pathname.split("/");
    return urlSegments[urlSegments.length - 1];
};

const loadProduct = async () => {
    isLoading.value = true;
    try {
        product.value = await fetchProduct(getProductIdFromUrl());
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(loadProduct);

const handleSubmit = async () => {
    try {
        const response = await createOrder({
            client_id: props.auth.user.id,
            products_data: [
                {
                    product_id: product.value.id,
                    price: product.value.price,
                    quantity: form.orderQuantity,
                },
            ],
        });
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

const submit = async () => {
    try {
        form.price = parseFloat(
            form.price.replace(/[R$.\s]/g, "").replace(",", ".")
        ).toString();

        const response = await updateProduct(product.value.id, form);
        closeModal();
        loadProduct();
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

const openModal = (product) => {
    isModalOpen.value = true;
    Object.assign(form, {
        name: product.name,
        description: product.description,
        price: product.price,
        stock_quantity: product.stock_quantity,
    });
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};
</script>

<template>
    <authenticatedLayout>
        <LoadingPlaceholder v-if="isLoading" />

        <ProductDetails
            v-else
            :product="product"
            :userRole="userRole"
            :form="form"
            @handleSubmit="handleSubmit"
            @edit="openModal"
        />

        <ModalContainer v-if="isModalOpen">
            <ModalContentUpdatedProduct
                :form="form"
                @submit="submit"
                @closeModal="closeModal"
            />
        </ModalContainer>
    </authenticatedLayout>
</template>
