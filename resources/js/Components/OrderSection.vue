<script setup>
import { ref, computed } from "vue";
import OrderItem from "./OrderItem.vue";

const props = defineProps({
    title: String,
    section: String,
    companies: Array,
    activeSection: String,
    order: Array,
});

const emits = defineEmits([
    "send-order",
    "delete-product-in-order",
    "increment-quantity",
    "decrement-quantity",
    "cancel-order",
    "accept-order",
    "denied-order",
]);

const selectedCompany = ref("");
const selectedStatus = ref("");

const filteredOrders = computed(() => {
    return props.order.filter((order) => {
        const companyMatch =
            !selectedCompany.value ||
            order.client_details.company === selectedCompany.value;
        const statusMatch =
            !selectedStatus.value || order.status === selectedStatus.value;
        return companyMatch && statusMatch;
    });
});
</script>

<template>
    <div v-if="activeSection === section" class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg">{{ title }}</h2>

            <div v-if="section === 'order'">
                <p
                    v-if="order[0]?.products_data.length > 0"
                    class="text-gray-500"
                >
                    Products in order: {{ order[0]?.products_data.length }}
                </p>
            </div>

            <div v-else>
                <p v-if="order.length > 0" class="text-gray-500">
                    Orders: {{ order.length }}
                </p>
            </div>
        </div>

        <div v-if="order.length > 0" class="flex flex-col gap-6">
            <select
                v-if="section === 'completed'"
                id="status-filter"
                v-model="selectedStatus"
                class="block w-full border rounded-md bg-white"
            >
                <option value="">All Statuses</option>

                <option value="accepted">Accepted</option>

                <option value="denied">Denied</option>

                <option value="cancelled">Cancelled</option>
            </select>

            <div v-if="section === 'allOrders'" class="flex gap-4">
                <select
                    id="company-filter"
                    v-model="selectedCompany"
                    class="block w-full border rounded-md bg-white"
                >
                    <option value="">All Companies</option>
                    <option
                        v-for="company in companies"
                        :key="company"
                        :value="company"
                    >
                        {{ company }}
                    </option>
                </select>

                <select
                    id="status-filter"
                    v-model="selectedStatus"
                    class="block w-full border rounded-md bg-white"
                >
                    <option value="">All Statuses</option>
                    <option value="accepted">Accepted</option>
                    <option value="denied">Denied</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div
                v-for="order in filteredOrders"
                :key="order.id"
                class="flex flex-col gap-6"
            >
                <OrderItem
                    :order="order"
                    :section="section"
                    @send-order="$emit('send-order')"
                    @cancel-order="
                        (order) => {
                            $emit('cancel-order', order);
                        }
                    "
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
                    @accept-order="
                        (order) => {
                            $emit('accept-order', order, 'accepted');
                        }
                    "
                    @denied-order="
                        (order) => {
                            $emit('denied-order', order, 'denied');
                        }
                    "
                />
            </div>
        </div>
        <p v-else class="text-gray-500">No order available at the moment.</p>
    </div>
</template>
