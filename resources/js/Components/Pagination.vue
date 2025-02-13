<template>
    <div class="flex justify-start">
        <!-- PREV PAGE -->
        <button
            :disabled="currentPage <= 1"
            @click="handlePageChange(currentPage - 1)"
            :class="[
                'py-1 px-2 mr-1 inline-flex justify-center items-center gap-2 rounded-lg border border-gray-500 font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm',
                { 'opacity-50 cursor-not-allowed': currentPage <= 1 },
            ]"
        >
            <ArrowLeft />
            Anterior
        </button>

        <!-- INITIAL PAGE -->
        <button
            v-if="pageRange[0] > 1"
            @click="handlePageChange(1)"
            class="py-1 px-4 mx-1 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm"
        >
            1
        </button>

        <!-- ILLIPSES -->
        <span v-if="pageRange[0] > 2" class="py-1 px-2">...</span>

        <!-- PAGES -->
        <button
            v-for="page in pageRange"
            :key="page"
            :class="{
                'border border-gray-500 bg-gray-200 text-gray-700':
                    page === currentPage,
                'bg-gray-100 text-gray-700 hover:bg-gray-200':
                    page !== currentPage,
            }"
            @click="handlePageChange(page)"
            class="py-1 px-4 mx-1 rounded-lg font-medium text-sm"
        >
            {{ page }}
        </button>

        <!-- ELLIPSES -->
        <span
            v-if="pageRange[pageRange.length - 1] < lastPage - 1"
            class="py-1 px-2"
        >
            ...
        </span>

        <!-- LAST PAGE -->
        <button
            v-if="pageRange[pageRange.length - 1] < lastPage"
            @click="handlePageChange(lastPage)"
            class="py-1 px-4 mx-1 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm"
        >
            {{ lastPage }}
        </button>

        <!-- NEXT PAGE -->
        <button
            :disabled="currentPage >= lastPage"
            @click="handlePageChange(currentPage + 1)"
            :class="[
                'py-1 px-2 ml-1 inline-flex justify-center items-center gap-2 rounded-lg border border-gray-500 font-medium bg-gray-100 text-gray-700 align-middle hover:bg-gray-200 transition-all text-sm',
                { 'opacity-50 cursor-not-allowed': currentPage >= lastPage },
            ]"
        >
            Próximo
            <ArrowRight />
        </button>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { generatePageRange } from "@/Utils/pagination";
import { ArrowLeft, ArrowRight } from "lucide-vue-next";

const props = defineProps({
    currentPage: Number,
    lastPage: Number,
    range: Number,
});

const emit = defineEmits(["update:currentPage"]);

const pageRange = computed(() => {
    return generatePageRange(
        props.lastPage,
        props.currentPage,
        props.range || 5
    );
});

const handlePageChange = (page) => {
    if (page >= 1 && page <= props.lastPage) {
        emit("update:currentPage", page);
    }
};
</script>
