<template>
    <div class="mx-auto overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <TableHeader colTitle="#id" />
                    <TableHeader colTitle="Foto" />
                    <TableHeader colTitle="Nome" />
                    <TableHeader colTitle="Descricao" />
                    <TableHeader colTitle="Preço Base" />
                    <TableHeader colTitle="Desconto" />
                    <TableHeader colTitle="Preço Final" />
                    <TableHeader colTitle="Quantidade" />
                    <TableHeader colTitle="Ver" />
                    <TableHeader colTitle="Editar" />
                    <TableHeader colTitle="Excluir" />
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <tr v-for="product in props.products" :key="product.id" class="bg-white hover:bg-gray-50">
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span class="font-mono text-sm text-blue-600">#{{ product.id }}</span>
                        </span>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <span class="block pl-3">
                            <img class="border object-cover size-10 rounded-lg ring-2 ring-white" :src="getProductimageUrl(product.image)"  :alt="product.name"/>
                        </span>
                     </td>

                    <TableData :data="product.name" />

                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span
                                class="text-sm text-gray-600 dark:text-neutral-400 overflow-hidden text-ellipsis whitespace-nowrap block w-80"
                                :title="product.description">
                                {{ product.description }}
                            </span>
                        </span>
                    </td>

                    <TableData :data="product.price" />

                    <td class="size-px whitespace-nowrap">
                        <span class="block px-3 py-2">
                            <span :class="product.discount > 0
                                ? 'bg-green-100 text-green-800 '
                                : 'bg-red-100 text-red-800'
                                "
                                class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium">
                                % {{ product.discount }}
                            </span>
                        </span>
                    </td>

                    <TableData :data="product.final_price" />
                    <TableData :data="product.quantity" />

                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.products.show', { id: product.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                        <ExternalLink />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link :href="route('admin.products.edit', { id: product.id })
                            "
                            class="py-1 px-2 mx-3 inline-flex justify-center items-center gap-2 rounded-lg border border-green-500 font-medium bg-green-100 text-green-700 align-middle hover:bg-green-200 transition-all text-sm">
                        <Clipboard />
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <button @click="openModal(product)"
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
                <h2 class="text-lg font-semibold mb-4">Excluir Produto</h2>
                <p>
                    Tem certeza que deseja excluir o produto:
                    <strong>{{ modalProduct.name }}</strong>?
                </p>
            </div>
            <div class="bg-gray-100 p-4 flex justify-end gap-4">
                <button @click="closeModal"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm">
                    Cancelar
                </button>
                <button @click="deleteProduct"
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
    products: Array,
});

const toast = useToast();

const isModalOpen = ref(false);
const modalProduct = ref(null);

const getProductimageUrl = (imagePath) =>
    imagePath && imagePath.startsWith("http")
        ? imagePath
        : `/storage/${imagePath}`;

const openModal = (product) => {
    modalProduct.value = product;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    modalProduct.value = null;
};

const emit = defineEmits(["productDeleted"]);

const deleteProduct = async () => {
    if (modalProduct.value) {
        try {
            const response = await Services.products.delete(modalProduct.value.id);
            closeModal();
            toast.success(response.message);
            emit("productDeleted");
        } catch (error) {
            toast.error(error.message[0]);
        }
    }
};
</script>
