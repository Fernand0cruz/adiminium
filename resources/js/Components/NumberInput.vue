<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const updateValue = () => {
    emit('update:modelValue', Number(input.value.value));
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="number"
        :value="modelValue"
        @input="updateValue"
        ref="input"
        min="1"
        autocomplete="off"
    />
</template>

<style scoped>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Remove as setas no Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}
</style>
