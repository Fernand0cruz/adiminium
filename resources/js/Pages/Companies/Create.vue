<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Cadastrar empresa no sistema" />
                <SectionSubTitle
                    subTitle="Preencha os campos abaixo para cadastrar uma empresa no sistema!"
                />
            </div>

            <!-- VIEW LIST COMPANIES -->
            <div>
                <Link
                    :href="route('admin.companies.index')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                >
                    <SquareChartGantt />
                    Ver Empresas
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
