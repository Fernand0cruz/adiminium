<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Sidebar from "@/Components/Sidebar.vue";
import SidebarLink from "@/Components/SidebarLink.vue";
import OrderSection from "@/Components/OrderSection.vue";
import LoadingPlaceholder from "@/Components/LoadingPlaceholder.vue";
import { ref, onMounted } from "vue";
import {
    fetchOrder,
    ordersInProgress,
    ordersCompleted,
    updateOrder,
    deleteOrder,
} from "@/Services/api";
import { useToast } from "vue-toastification";

const order = ref([]);
const inProgress = ref([]);
const completed = ref([]);
const activeSection = ref("order");
const toast = useToast();
const isLoading = ref(false);

const changeSection = (section) => {
    activeSection.value = section;
};

const loadOrder = async () => {
    isLoading.value = true;
    try {
        order.value = await fetchOrder();
        inProgress.value = await ordersInProgress();
        completed.value = await ordersCompleted();
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
};

onMounted(loadOrder);

const updateOrderData = async (orderId, OrderUpdated) => {
    try {
        const response = await updateOrder(orderId, OrderUpdated);
        toast.success(response);
        loadOrder();
    } catch (error) {
        toast.error(error.message);
    }
};

const sendOrder = async () => {
    try {
        const updatedOrder = {
            ...order.value[0],
            status: "in progress",
            products_data: order.value[0].products_data.map((product) => ({
                product_id: product.product_details?.id,
                price: product.price,
                quantity: product.quantity,
            })),
        };

        updateOrderData(order.value[0]?.id, updatedOrder);
    } catch (error) {
        toast.error(error.message);
    }
};

const deleteProductInOrder = async (index) => {
    try {
        order.value[0].products_data.splice(index, 1);
        if (!order.value[0].products_data.length) {
            const response = await deleteOrder(order.value[0].id);
            toast.success(response);
            loadOrder();
            return;
        }

        updateOrderData(order.value[0].id, getUpdatedOrder());
    } catch (error) {
        toast.error(error.message);
    }
};

const incrementQuantity = (index) => updateQuantity(index, 1);
const decrementQuantity = (index) => updateQuantity(index, -1);

const getUpdatedOrder = () => ({
    id: order.value[0].id,
    ...order.value[0],
    products_data: order.value[0].products_data.map(
        ({ product_details, price, quantity }) => ({
            product_id: product_details.id,
            price,
            quantity,
        })
    ),
});

const updateQuantity = (index, change) => {
    const product = order.value[0].products_data[index];
    const newQuantity = product.quantity + change;
    const maxStock = product.product_details.stock_quantity;

    if (newQuantity < 1 || newQuantity > maxStock) {
        toast.error(
            newQuantity < 1
                ? "Quantity must be at least 1."
                : "Quantity exceeds available stock."
        );
        return;
    }

    product.quantity = newQuantity;
    updateOrderData(order.value[0].id, getUpdatedOrder());
};

const cancelOrder = async (order) => {
    try {
        const updatedOrder = {
            ...order,
            status: "cancelled",
            products_data: order.products_data.map((product) => ({
                product_id: product.product_details?.id,
                price: product.price,
                quantity: product.quantity,
            })),
        };
        updateOrderData(order.id, updatedOrder);
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
                    label="Order"
                    section="order"
                    :activeSection="activeSection"
                    @change-section="changeSection"
                />

                <SidebarLink
                    label="In Progress"
                    section="inProgress"
                    :activeSection="activeSection"
                    @change-section="changeSection"
                />

                <SidebarLink
                    label="Completed"
                    section="completed"
                    :activeSection="activeSection"
                    @change-section="changeSection"
                />
            </Sidebar>

            <main class="flex-1 px-6">
                <LoadingPlaceholder v-if="isLoading && activeSection !== 'order'" />
                
                <template v-else>
                    <OrderSection
                        title="Order"
                        section="order"
                        :activeSection="activeSection"
                        :order="order"
                        @send-order="sendOrder"
                        @increment-quantity="incrementQuantity"
                        @decrement-quantity="decrementQuantity"
                        @delete-product-in-order="deleteProductInOrder"
                    />

                    <OrderSection
                        title="In Progress"
                        section="inProgress"
                        :activeSection="activeSection"
                        :order="inProgress"
                        @cancel-order="cancelOrder"
                    />

                    <OrderSection
                        title="Completed"
                        section="completed"
                        :activeSection="activeSection"
                        :order="completed"
                    />
                </template>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
