<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import ClientDetails from "@/Components/ClientDetails.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import ModalContentUpdatedClient from "@/Components/ModalContentUpdatedClient.vue";
import { onMounted } from "vue";
import { ref } from "vue";
import { fetchClient, updateClient } from "@/Services/api";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/vue3";

const client = ref({});
const isLoading = ref(false);
const isModalOpen = ref(false);
const toast = useToast();

const getClientFromUrl = () => {
    const urlSegments = window.location.pathname.split("/");
    return urlSegments[urlSegments.length - 1];
};

const loadClient = async () => {
    isLoading.value = true;
    try {
        client.value = await fetchClient(getClientFromUrl());
    } catch(error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(loadClient);

const openModal = (client) => {
    isModalOpen.value = true;
    Object.assign(form, {
        company: client.company,
        name: client.name,
        email: client.email,
        phone: client.phone,
    });
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

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
        const response = await updateClient(client.value.id, form);
        closeModal();
        loadClient();
        toast.success(response);
    } catch (error) {
        toast.error(error.message);
    }
};
</script>
<template>
    <AuthenticatedLayout>
        <LoadingPlaceholder v-if="isLoading" />

        <ClientDetails v-else :client="client" @edit="openModal" />

        <ModalContainer v-if="isModalOpen">
            <ModalContentUpdatedClient
                :form="form"
                @submit="submit"
                @closeModal="closeModal"
            />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
