<script setup>
import PrimaryButton from "./PrimaryButton.vue";

const props = defineProps({
    currentPage: Number,
    lastPage: Number,
});

const emits = defineEmits(["changePage"]);
</script>

<template>
    <div class="flex items-center gap-6">
        <PrimaryButton
            :disabled="currentPage === 1"
            @click="$emit('changePage', currentPage - 1)"
            class="px-4 py-2 rounded"
        >
            Previous
        </PrimaryButton>

        <div class="flex gap-2">
            <button
                v-for="page in Array.from(
                    { length: lastPage },
                    (_, i) => i + 1
                )"
                :key="page"
                :class="{ 'bg-gray-100': currentPage === page }"
                @click="$emit('changePage', page)"
                class="px-4 py-2 rounded"
            >
                {{ page }}
            </button>
        </div>

        <PrimaryButton
            :disabled="currentPage === lastPage"
            @click="$emit('changePage', currentPage + 1)"
            class="px-4 py-2 rounded"
        >
            Next
        </PrimaryButton>
    </div>
</template>
