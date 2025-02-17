<template>
    <input
        type="text"
        :value="modelValue"
        @input="updateValue"
        @keydown="preventNonNumeric"
        :placeholder="placeholder"
        autocomplete="off"
        class="py-2 px-3 w-full border-gray-200 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
    />
</template>

<script setup>
defineProps({
    modelValue: [String, Number],
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    const value = event?.target?.value || "";
    const numericValue = value.replace(/[^\d]/g, "");
    emit("update:modelValue", Number(numericValue));
};

const preventNonNumeric = (event) => {
    if (!/\d/.test(event.key) && !["Backspace", "Tab", "ArrowLeft", "ArrowRight", "Delete"].includes(event.key)) {
        event.preventDefault();
    }
};
</script>
