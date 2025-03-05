<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="'Carregando...'" />
                <SectionSubTitle subTitle="Veja mais informações sobre a empresa abaixo!" />
            </div>

            <!-- UPDATE COMPANY -->
            <div v-if="userRole === 'admin'">
                <Link :href="route('admin.companies.edit', { id: companyId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <SquareChartGantt />
                Editar Empresa
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
import { SquareChartGantt } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
</script>