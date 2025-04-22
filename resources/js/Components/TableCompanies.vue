<template>
    <div class="mx-auto overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <TableHeader colTitle="#id" />
                    <TableHeader colTitle="Logo" />
                    <TableHeader colTitle="Razao Social" />
                    <TableHeader colTitle="CNPJ" />
                    <TableHeader colTitle="Telefone" />
                    <TableHeader colTitle="Email" />
                    <TableHeader colTitle="Cidade" />
                    <TableHeader colTitle="Responsavel" />
                    <TableHeader colTitle="Ver" />
                    <TableHeader colTitle="Editar" />
                    <TableHeader colTitle="Excluir" />
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <tr v-for="company in props.companies" :key="company.id" class="bg-white hover:bg-gray-50">
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span class="font-mono text-sm text-blue-600">#{{ company.id }}</span>
                        </span>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <span class="block pl-3">
                            <img class="border object-cover size-10 rounded-lg ring-2 ring-white"
                                :src="getProductimageUrl(company.image)" />
                        </span>
                    </td>

                    <TableData :data="company.business_name" />

                    <TableData :data="company.cnpj" />

                    <TableData :data="company.phone" />

                    <TableData :data="company.email" />

                    <TableData :data="company.city" />

                    <td class="size-px whitespace-nowrap px-3">
                        <template v-if="company.user">
                            <Link :href="route('admin.clients.show', { id: company.user.id })" class="text-blue-800 underline capitalize">
                            {{ company.user.name }}
                            </Link>
                        </template>
                        <span v-else class=" text-gray-400">-</span>
                    </td>


                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.companies.show', { id: company.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                        <ExternalLink />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.companies.edit', { id: company.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-green-500 font-medium bg-green-100 text-green-700 align-middle hover:bg-green-200 transition-all text-sm">
                        <Clipboard />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <button @click="openModal(company)"
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
                <h2 class="text-lg font-semibold mb-4">Excluir Empresa</h2>
                <p>
                    Tem certeza que deseja excluir a empresa:
                    <strong>{{ modalCompany.business_name }}</strong>?
                </p>
                <p class=" text-red-500">Ao excluir a empresa, o cliente responsável por gerenciar os pedidos também será excluído, juntamente com todos os dados relacionados à empresa.*</p>
            </div>
            <div class="bg-gray-100 p-4 flex justify-end gap-4">
                <button @click="closeModal"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm">
                    Cancelar
                </button>
                <button @click="deleteCompany"
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
    companies: Array,
});

const toast = useToast();

const isModalOpen = ref(false);
const modalCompany = ref(null);

const openModal = (company) => {
    modalCompany.value = company;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    modalCompany.value = null;
};

const emit = defineEmits(["companyDeleted"]);

const getProductimageUrl = (imagePath) =>
    imagePath && imagePath.startsWith("http")
        ? imagePath
        : `/storage/${imagePath}`;

const deleteCompany = async () => {
    if (modalCompany.value) {
        try {
            const response = await Services.companies.delete(modalCompany.value.id)
            closeModal();
            toast.success(response.message);
            emit("companyDeleted");
        } catch (error) {
            toast.error(error.message[0]);
        }
    }
};
</script>
