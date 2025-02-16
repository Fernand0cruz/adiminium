<template>
    <AuthenticatedLayout>
        <div>
            <SectionTitle title="Dashboard" />
            <SectionSubTitle subTitle="Gráficos com informações dos produtos e clientes cadastrados no sistema, e outros!" />
        </div>
        <div>graficos</div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SectionSubTitle from "@/Components/SectionSubTitle.vue";
</script>
