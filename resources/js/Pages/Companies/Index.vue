<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Empresas cadastradas no sistema" />
                <SectionSubTitle subTitle="Listagem das empresas com opção de deletar empresas ou editar!" />
            </div>

            <!-- ADD NEW COMPANY -->
            <div>
                <Link :href="route('admin.companies.create')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <SquareChartGantt/>
                Nova Empresa
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { SquareChartGantt } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
</script>