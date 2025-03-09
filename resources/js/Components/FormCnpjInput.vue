<template>
    <input
        type="text"
        v-model="formattedValue"
        v-mask="'##.###.###/####-##'"
        :placeholder="placeholder"
        autocomplete="off"
        class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500"
    />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const formattedValue = computed({
    get: () => {
        return props.modelValue ? props.modelValue.toString() : '';
    },
    set: (val) => {
        const numericValue = val.replace(/[^\d]/g, "");
        emit("update:modelValue", numericValue);
    },
});
</script>
