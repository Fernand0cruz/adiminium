<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle title="Editar produto" />
                <SectionSubTitle
                    subTitle="Edite os campos abaixo para modificar dados do produto no sistema!"
                />
            </div>

            <!-- UPDATE PRODUCT -->
            <div>
                <Link
                    :href="route('admin.products.show', { id: productId})"
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                >
                    <Package />
                    Ver Produto
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
import { Package } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import Services from '@/Services';

const productId = route().params.id;
const product = ref({});
</script>