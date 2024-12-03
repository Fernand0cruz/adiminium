<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Sidebar from "@/Components/Sidebar.vue";
import SidebarLink from "@/Components/SidebarLink.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import OrderSection from "@/Components/OrderSection.vue";
import { useToast } from "vue-toastification";
import { ref, onMounted } from "vue";
import { allOrdersInProgress, allOrders, updateOrder } from "@/Services/api";

const activeSection = ref("ordersForAction");
const toast = useToast();
const ordersForAction = ref([]);
const allOrdersData = ref([]);
const companies = ref([]);
const selectedCompany = ref("");
const selectedStatus = ref("");
const isLoading = ref(true);

const changeSection = (section) => {
    activeSection.value = section;
};

const loadOrders = async () => {
    isLoading.value = true;
    try {
        ordersForAction.value = await allOrdersInProgress();
        allOrdersData.value = await allOrders();
        companies.value = allOrdersData.value
            .map((order) => order.client_details.company)
            .filter((value, index, self) => self.indexOf(value) === index);
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(loadOrders);

const updateOrderData = async (orderId, OrderUpdated) => {
    try {
        const response = await updateOrder(orderId, OrderUpdated);
        toast.success(response);
    } catch (error) {
        toast.error(error.message);
    }
};

const orderStatus = async (order, status) => {
    try {
        const updatedOrder = {
            ...order,
            status: status,
            products_data: order.products_data.map((product) => ({
                product_id: product.product_details?.id,
                price: product.price,
                quantity: product.quantity,
            })),
        };
        updateOrderData(order.id, updatedOrder);
        await loadOrders();
    } catch (error) {
        toast.error(error.message);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex">
            <Sidebar>
                <SidebarLink
                    label="Orders for action"
                    section="ordersForAction"
                    :activeSection="activeSection"
                    @change-section="changeSection"
                />

                <SidebarLink
                    label="All Orders"
                    section="allOrders"
                    :activeSection="activeSection"
                    @change-section="changeSection"
                />
            </Sidebar>

            <main class="flex-1 px-6">
                <LoadingPlaceholder v-if="isLoading" />

                <template v-else>
                    <OrderSection 
                        title="Orders for Action"
                        section="ordersForAction"
                        :activeSection="activeSection"
                        :order="ordersForAction"
                        @accept-order="orderStatus"
                        @denied-order="orderStatus"
                    />

                    <OrderSection 
                        title="All Orders"
                        section="allOrders"
                        :companies="companies"
                        :activeSection="activeSection"
                        :order="allOrdersData"
                    />
                </template>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
