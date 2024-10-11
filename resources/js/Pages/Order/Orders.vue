<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

// rever: apos authenticação da api ajustar controllador para fazer buscas no db trazendo junto com os pedidos os produtos e os user q abriram o pedido

const allOrders = ref([]);

onMounted(async () => await fetchOrders() );

const fetchOrders = async () => {
    const response = await axios('/api/allorders')
    allOrders.value = response.data.allOrders
}
</script>

<template>

    <Head title="home" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Pedidos

                        <div>
                            {{ allOrders }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>