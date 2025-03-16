<template>
    <AuthenticatedLayout>

        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Cadastrar cliente no sistema" />
                <SectionSubTitle subTitle="Preencha os campos abaixo para cadastrar um cliente no sistema!" />
            </div>

            <!-- VIEW LIST CLIENTS -->
            <div>
                <Link :href="route('admin.clients.index')"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Users />
                Ver Clientes
                </Link>
            </div>
        </div>

        <!-- FORM FOR REGISTER CLIENT IN THE SYSTEM -->
        <ClientForm />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import { Link } from '@inertiajs/vue3';
import { Users } from 'lucide-vue-next';
import ClientForm from '@/Components/ClientForm.vue';
</script>
