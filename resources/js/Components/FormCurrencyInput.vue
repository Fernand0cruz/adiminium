<template>
    <input
        type="text"
        v-model="formattedValue"
        @keydown="preventNonNumeric"
        :placeholder="placeholder"
        autocomplete="off"
        class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500"
    />
</template>

<script setup>
import { computed } from "vue";
import { formatCurrency } from "@/Utils/formatCurrency";

const props = defineProps({
    modelValue: [String, Number],
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const formattedValue = computed({
    get: () => props.modelValue ? formatCurrency(props.modelValue) : "",
    set: (val) => {
        const numericValue = parseFloat(val.replace(/[^\d]/g, "")) / 100;
        emit("update:modelValue", isNaN(numericValue) ? 0 : numericValue);
    }
});

function preventNonNumeric(event) {
    if (!/\d/.test(event.key) && !["Backspace", "Tab", "ArrowLeft", "ArrowRight", "Delete"].includes(event.key)) {
        event.preventDefault();
    }
}
</script>
