<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="'Editar cliente: ' + (user.name || 'Carregando...')" />
                <SectionSubTitle subTitle="Edite os campos abaixo para modificar dados do client no sistema!" />
            </div>

            <!-- UPDATE CLIENTS -->
            <div>
                <Link :href="route('admin.clients.show', { id: userId })"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm">
                <Users />
                Ver Cliente
                </Link>
            </div>
        </div>

         <!-- LOADING DATA -->
         <div v-if="loading">
            <p class="text-gray-500 text-center py-[31px]">
                Carregando Cliente...
            </p>
        </div>

        <!-- FORM FOR EDIT CLIENT IN THE SYSTEM -->
        <ClientForm :user="user" :errorMessage="errorMessage" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Users } from 'lucide-vue-next';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import { Link } from '@inertiajs/vue3';
import ClientForm from '@/Components/ClientForm.vue';
import { onMounted, ref } from 'vue';
import Services from '@/Services/api/index.js';

const userId = route().params.id;
const user = ref({});
const errorMessage = ref(null);
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    try {
        const { phone, ...rest } = await Services.clients.get(userId);
        user.value = {
            ...rest,
            phone: phone.replace(/\D/g, ''),
        };
    } catch (error) {
        errorMessage.value = error.message?.[0];
    } finally {
        loading.value = false;
    }
});
</script>
