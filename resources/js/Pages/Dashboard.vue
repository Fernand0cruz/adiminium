<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-4">
            <SectionTitle title="Dashboard" />
            <SectionSubTitle subTitle="Gráficos com informações do sistema" />
        </div>
        <div>graficos</div>
    </AuthenticatedLayout>
</template>
