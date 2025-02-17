<template>
    <input
        type="text"
        v-model="formattedValue"
        @keydown="preventNonNumeric"
        :placeholder="placeholder"
        autocomplete="off"
        class="py-2 px-3 w-full border-gray-200 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
    />
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const limitValue = (value) => Math.min(value, 99.99).toFixed(2);

const formattedValue = computed({
    get: () => {
        const value = parseFloat(props.modelValue) || 0;
        return value === 0 ? "" : limitValue(value);
    },
    set: (val) => {
        const numericValue = parseFloat(val.replace(/[^\d]/g, "")) / 100;
        emit("update:modelValue", isNaN(numericValue) ? 0 : Math.min(numericValue, 99.99));
    },
});

function preventNonNumeric(event) {
    const allowedKeys = ["Backspace", "Tab", "ArrowLeft", "ArrowRight", "Delete"];
    const nextChar = event.key;
    const currentValue = event.target.value + nextChar;

    if (!/\d/.test(nextChar) && !allowedKeys.includes(nextChar) || parseFloat(currentValue.replace(/[^\d]/g, "")) / 100 > 99.99) {
        event.preventDefault();
    }
}
</script>
