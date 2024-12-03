<script setup>
import { defineProps, defineEmits } from "vue";
import ProductItem from "./ProductItem.vue";
import PrimaryButton from "./PrimaryButton.vue";
import DangerButton from "./DangerButton.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    order: Object,
    section: String,
});

const emits = defineEmits([
    "send-order",
    "cancel-order",
    "decrement-quantity",
    "increment-quantity",
    "delete-product-in-order",
    "accept-order",
    "denied-order",
]);

const statusColor = computed(() => {
    switch (props.order.status) {
        case "in progress":
            return "text-blue-500";
        case "cancelled":
            return "text-red-500";
        case "accepted":
            return "text-green-500";
        case "denied":
            return "text-red-500";
        default:
            return "text-gray-500";
    }
});

const { props: pageProps } = usePage();
const userRole = pageProps.auth.user.role;

const formatCurrency = (value) => {
    if (!value) return "R$ 0,00";

    const number = parseFloat(value);
    if (isNaN(number)) return "R$ 0,00";

    return `R$ ${number.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })}`;
};

const formatDate = (date) => {
    if (!date) return ""; 
    const parsedDate = new Date(date); 
    return parsedDate.toLocaleString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",  
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });
};

</script>

<template>
    <div :key="order.id" class="border p-6 flex flex-col gap-4 rounded-md">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl">Order #{{ order.id }}</h2>

                <div class="text-gray-500">
                    <p v-if="userRole === 'admin'">
                        <strong>Company:</strong>
                        {{ order.client_details.company }}
                    </p>
                    <p v-if="userRole === 'admin'">
                        <strong>Client:</strong>
                        {{ order.client_details.name }}
                    </p>
                    <p v-if="order.status !== 'open'" :class="statusColor">
                        <strong>Status:</strong> {{ order.status }}
                    </p>
                    <p v-if="order.status === 'in progress'">
                        <strong>Date Send:</strong>
                        {{ formatDate(order.created_at) }}
                    </p>

                    <p v-if="order.status === 'cancelled'">
                        <strong>Date Canceled:</strong>
                        {{ formatDate(order.updated_at) }}
                    </p>

                    <p v-if="order.status === 'accepted'">
                        <strong>Date Accepted:</strong>
                        {{ formatDate(order.updated_at) }}
                    </p>

                    <p v-if="order.status === 'denied'">
                        <strong>Date Denied:</strong>
                        {{ formatDate(order.updated_at) }}
                    </p>
                    <p>
                        <strong>Total Price:</strong>
                        {{
                            formatCurrency(
                                order.products_data.reduce(
                                    (total, product) =>
                                        total +
                                        product.price * product.quantity,
                                    0
                                )
                            )
                        }}
                    </p>
                </div>
            </div>

            <div class="space-x-6">
                <PrimaryButton
                    v-if="section === 'order'"
                    @click="$emit('send-order')"
                    >Send Order</PrimaryButton
                >

                <DangerButton
                    v-if="section === 'inProgress'"
                    @click="$emit('cancel-order', order)"
                    >Cancel Order</DangerButton
                >

                <PrimaryButton
                    v-if="section === 'ordersForAction'"
                    @click="$emit('accept-order', order)"
                    >Accept Order</PrimaryButton
                >

                <DangerButton
                    v-if="section === 'ordersForAction'"
                    @click="$emit('denied-order', order)"
                    >Denied Order</DangerButton
                >
            </div>
        </div>

        <h3 class="font-semibold text-lg">Products:</h3>

        <div v-for="(product, index) in order.products_data" :key="index">
            <ProductItem
                :product="product"
                :index="index"
                :section="section"
                @decrement-quantity="
                    (index) => {
                        $emit('decrement-quantity', index);
                    }
                "
                @increment-quantity="
                    (index) => {
                        $emit('increment-quantity', index);
                    }
                "
                @delete-product-in-order="
                    (index) => {
                        $emit('delete-product-in-order', index);
                    }
                "
            />
        </div>
    </div>
</template>
