<template>
    <textarea
        :value="modelValue"
        @input="updateValue"
        :placeholder="placeholder"
        class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none"
        rows="8"
    ></textarea>
</template>

<script setup>
defineProps({
    modelValue: String,
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    emit("update:modelValue", event?.target?.value || "");
};
</script>
