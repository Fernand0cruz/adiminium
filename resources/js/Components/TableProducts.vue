<template>
    <div class="mx-auto overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <TableHeader colTitle="#id" />

                    <TableHeader colTitle="Nome" />

                    <TableHeader colTitle="Preço Base" />

                    <TableHeader colTitle="Desconto" />

                    <TableHeader colTitle="Preço Final" />

                    <TableHeader colTitle="Quantidade" />

                    <th></th>

                    <th></th>

                    <th></th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <tr
                    v-for="product in props.products"
                    class="bg-white hover:bg-gray-50"
                >
                    <td class="size-px whitespace-nowrap">
                        <span class="block px-6 py-2">
                            <span class="font-mono text-sm text-blue-600"
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
                                        ? 'bg-green-100 text-green-800 '
                                        : 'bg-red-100 text-red-800'
                                "
                                class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium"
                            >
                                % {{ product.discount }}
                            </span>
                        </span>
                    </td>

                    <TableData :data="product.final_price" />

                    <TableData :data="product.quantity" />

                    <td class="size-px whitespace-nowrap">
                        <Link
                            :href="
                                route('admin.products.show', { id: product.id })
                            "
                            class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                        >
                            <ExternalLink />
                            Visualizar
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link
                            href=""
                            class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-green-500 font-medium bg-green-100 text-green-700 align-middle hover:bg-green-200 transition-all text-sm"
                        >
                            <Clipboard />
                            Editar
                        </Link>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <Link
                            href=""
                            class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-red-500 font-medium bg-red-100 text-red-700 align-middle hover:bg-red-200 transition-all text-sm"
                        >
                            <Trash />
                            Excluir
                        </Link>
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
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    products: Object,
});
</script>
