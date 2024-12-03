<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import Pagination from "@/Components/Pagination.vue";
import ClientsTable from "@/Components/ClientsTable.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import ModalContentDeleteItem from "@/Components/ModalContentDeleteItem.vue";
import { onMounted, ref } from "vue";
import { deleteClient, fetchClients } from "@/Services/api";
import { useToast } from "vue-toastification";

const toast = useToast();
const clients = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const isLoading = ref(false);
const isModalOpen = ref(false);
const selectedClient = ref(null);

const loadClients = async (page) => {
    isLoading.value = true;
    try {
        const response = await fetchClients(page);
        clients.value = response.data;
        currentPage.value = response.current_page;
        lastPage.value = response.last_page;
        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => loadClients(currentPage.value));

const openModal = (itemId) => {
    selectedClient.value = itemId;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const deleteItem = async () => {
    if (!selectedClient.value) return;
    try {
        const response = await deleteClient(selectedClient.value);
        closeModal();
        loadClients(currentPage.value);
        toast.success(response);
    } catch (error) {
        toast.error(error.message);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <LoadingPlaceholder v-if="isLoading" />

        <div v-else class="flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-lg">Clients in the system</h1>

                <p v-if="clients.length > 0" class="text-gray-500">
                    Current page: {{ currentPage }}
                </p>
            </div>

            <ClientsTable :clients="clients" @openModal="openModal" />
        </div>

        <Pagination
            :currentPage="currentPage"
            :lastPage="lastPage"
            @changePage="loadClients"
        />

        <ModalContainer v-if="isModalOpen">
            <ModalContentDeleteItem
                label="client"
                @confirmDelete="deleteItem"
                @closeModal="closeModal"
            />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
