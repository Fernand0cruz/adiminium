<template>
    <input
        type="text"
        :value="modelValue"
        @input="updateValue"
        :placeholder="placeholder"
        autocomplete="off"
        class="py-2 px-3 w-full border-gray-200 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
    />
</template>

<script setup>
defineProps({
    modelValue: String,
    placeholder: String
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    emit("update:modelValue", event?.target?.value || "");
};
</script>
