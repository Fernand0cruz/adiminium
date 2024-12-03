<script setup>
import PrimaryButton from "./PrimaryButton.vue";
import DangerButton from "./DangerButton.vue";

const props = defineProps({
    clients: Array,
});

const viewClient = (clientId) => {
    window.location.href = `/client/${clientId}`;
};

const emits = defineEmits(["openModal"]);
</script>

<template>
    <table v-if="clients.length > 0" class="min-w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-4">Company</th>

                <th class="border p-4">Name</th>

                <th class="border p-4">Email</th>

                <th class="border p-4">Phone</th>

                <th class="border p-4">Delete</th>

                <th class="border p-4">View</th>
            </tr>
        </thead>

        <tbody>
            <tr
                v-for="client in clients"
                :key="client.id"
                class="hover:bg-gray-100 text-gray-500"
            >
                <td class="border p-3">{{ client.company }}</td>

                <td class="border p-3">{{ client.name }}</td>

                <td class="border p-3">{{ client.email }}</td>

                <td class="border p-3">{{ client.phone }}</td>

                <td class="border p-3 text-center">
                    <DangerButton @click="$emit('openModal', client.id)"
                        >Delete</DangerButton
                    >
                </td>
                
                <td class="border p-3 text-center">
                    <PrimaryButton @click="viewClient(client.id)"
                        >View</PrimaryButton
                    >
                </td>
            </tr>
        </tbody>
    </table>
    <p v-else class="text-gray-500">No clients available at the moment.</p>
</template>

<style scoped>
/* Your styles here */
</style>
