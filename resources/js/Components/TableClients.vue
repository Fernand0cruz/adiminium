<template>
    <div class="mx-auto overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <TableHeader colTitle="#id" />
                    <TableHeader colTitle="Nome" />
                    <TableHeader colTitle="Email" />
                    <TableHeader colTitle="Telefone" />
                    <TableHeader colTitle="Role" />
                    <TableHeader colTitle="Empresa" />
                    <TableHeader colTitle="Ver" />
                    <TableHeader colTitle="Editar" />
                    <TableHeader colTitle="Excluir" />
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="client in props.clients" :key="client.id" class="bg-white hover:bg-gray-50">
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span class="font-mono text-sm text-blue-600">#{{ client.id }}</span>
                        </span>
                    </td>

                    <TableData :data="client.name" />

                    <TableData :data="client.email" />

                    <TableData :data="client.phone" />

                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span :class="client.role === 'client'
                                ? 'bg-green-100 text-green-800 '
                                : 'bg-red-100 text-red-800'
                                "
                                class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium">
                                {{ client.role }}
                            </span>
                        </span>
                    </td>

                    <td class="size-px whitespace-nowrap px-3">
                        <template v-if="client.company">
                            <Link :href="route('admin.companies.show', { id: client.company.id })"
                                class="text-blue-800 underline capitalize">
                            {{ client.company.business_name }}
                            </Link>
                        </template>
                        <span v-else class=" text-gray-400">-</span>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.clients.show', { id: client.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                        <ExternalLink />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.clients.edit', { id: client.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-green-500 font-medium bg-green-100 text-green-700 align-middle hover:bg-green-200 transition-all text-sm">
                        <Clipboard />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <button @click="openModal(client)"
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm">
                            <Trash />
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <!-- Modal for Deletion Confirmation -->
    <div v-if="isModalOpen"
        class="z-[75] top-[-17px] fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white w-[650px] rounded-lg overflow-hidden border">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Excluir Cliente</h2>
                <p>
                    Tem certeza que deseja excluir o cliente:
                    <strong>{{ modalClient.name }}</strong>?
                </p>
                <p class=" text-red-500">Ao excluir este cliente, a empresa {{ modalClient.company.business_name }} ficará sem nenhum representante, impossibilitando a realização de novos pedidos até que um novo cliente responsável seja inserido.*</p>
            </div>
            <div class="bg-gray-100 p-4 flex justify-end gap-4">
                <button @click="closeModal"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm">
                    Cancelar
                </button>
                <button @click="deleteClient"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm">
                    <Trash />
                    Excluir
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Clipboard, ExternalLink, Trash } from "lucide-vue-next";
import TableHeader from "./TableHeader.vue";
import TableData from "./TableData.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import Services from "@/Services/api/index.js";
import { useToast } from "vue-toastification";

const props = defineProps({
    clients: Array,
});

const toast = useToast();

const isModalOpen = ref(false);
const modalClient = ref(null);

const openModal = (client) => {
    modalClient.value = client;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    modalClient.value = null;
};

const emit = defineEmits(["clientDeleted"]);

const deleteClient = async () => {
    if (modalClient.value) {
        try {
            const response = await Services.clients.delete(modalClient.value.id)
            closeModal();
            toast.success(response.message);
            emit("clientDeleted");
        } catch (error) {
            toast.error(error.message[0]);
        }
    }
};
</script>
