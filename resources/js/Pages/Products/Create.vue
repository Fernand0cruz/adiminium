<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Cadastrar produto no sistema" />
                <SectionSubTitle subTitle="Preencha os campos abaixo para cadastrar um produto no sistema!" />
            </div>

            <!-- VIEW LIST PRODUCTS -->
            <div>
                <Link :href="route('admin.products.index')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Package2 />
                Ver Produtos
                </Link>
            </div>
        </div>

        <!-- FORM FOR REGISTER PRODUCT IN THE SYSTEM -->
        <ProductForm />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { Package2 } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import ProductForm from "@/Components/ProductForm.vue";
</script>
