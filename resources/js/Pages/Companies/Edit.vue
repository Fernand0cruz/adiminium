<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="'Editar empresa: ' + 'Carregando...'" />
                <SectionSubTitle subTitle="Edite os campos abaixo para modificar dados da empresa no sistema!" />
            </div>

            <!-- UPDATE COMPANY -->
            <div>
                <Link :href="route('admin.companies.show', { id: 3 })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <SquareChartGantt />
                Ver Empresa
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import { Link } from "@inertiajs/vue3";
import { SquareChartGantt } from 'lucide-vue-next';
</script>