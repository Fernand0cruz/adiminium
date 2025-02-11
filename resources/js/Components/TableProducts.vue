<template>
    <div class="mx-auto overflow-hidden overflow-x-auto">
        <table
            class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
        >
            <thead class="bg-gray-50 dark:bg-neutral-900">
                <tr>
                    <TableHeader colTitle="#id" />

                    <TableHeader colTitle="Nome" />

                    <TableHeader colTitle="Preço Base" />

                    <TableHeader colTitle="Promoção" />

                    <TableHeader colTitle="Preço Final" />

                    <TableHeader colTitle="Quantidade" />

                    <th></th>

                    <th></th>

                    <th></th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                <tr
                    v-for="product in props.products?.data?.data"
                    class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800"
                >
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-6 py-2">
                            <span
                                class="font-mono text-sm text-blue-600 dark:text-blue-500"
                                >#{{ product.id }}</span
                            >
                        </span>
                    </td>
                    
                    <TableData :data="product.name" />

                    <TableData :data="product.price" />
                    
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-6 py-2">
                            <span
                                :class="
                                    product.discount > 0
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-green-200'
                                "
                                class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium"
                            >
                                % {{ product.discount }}
                            </span>
                        </span>
                    </td>

                    <TableData data="R$" />
                    
                    <TableData :data="product.stock_quantity" />

                    <td class="size-px whitespace-nowrap">
                        <button type="button" class="block">
                            <span class="py-1.5">
                                <span
                                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                                >
                                    <ExternalLink />
                                    Visualizar
                                </span>
                            </span>
                        </button>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <button type="button" class="block">
                            <span class="py-1.5">
                                <span
                                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-green-500 font-medium bg-green-100 text-green-700 align-middle hover:bg-green-200 transition-all text-sm"
                                >
                                    <Clipboard />
                                    Editar
                                </span>
                            </span>
                        </button>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <button type="button" class="block">
                            <span class="py-1.5">
                                <span
                                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm"
                                >
                                    <Trash />
                                    Excluir
                                </span>
                            </span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { Clipboard, ExternalLink, Trash } from "lucide-vue-next";
import TableHeader from "./TableHeader.vue";
import TableData from "./TableData.vue";

const props = defineProps({
    products: Object,
});
</script>
