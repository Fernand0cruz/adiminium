<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-end">
            <!-- TITLE -->
            <div>
                <SectionTitle :title="product.name" />
                <SectionSubTitle
                    subTitle="Veja mais informacoes sobre o produto abaixo!"
                />
            </div>

            <!-- UPDATE PRODUCT -->
            <div v-if="userRole === 'admin'">
                <Link
                    href=""
                    class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border border-indigo-500 font-medium bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-sm"
                >
                    <Package />
                    Editar Produto
                </Link>
            </div>
        </div>
        {{ product }}
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionSubTitle from '@/Components/SectionSubTitle.vue';
import { Package } from 'lucide-vue-next';
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import Services from '@/Services';

const { props } = usePage();
const userRole = props.auth.user.role;

const product = ref({});
const errorMessage = ref(null);

const productId = route().params.id;

const loadData = async () => {
    try {
        const response = await Services.products.get(productId)
        product.value = response
    } catch (error) {
        errorMessage.value =
            "Erro ao carregar produto. Tente novamente mais tarde!";
    }
};

onMounted(loadData);
</script>