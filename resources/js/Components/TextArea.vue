<script setup>
import { onMounted, ref, defineProps, defineEmits, defineExpose } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);
const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({
    focus: () => textarea.value.focus(),
});

const onInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <textarea
        class="rounded-md border-gray-300 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        :value="modelValue" 
        @input="onInput" 
        ref="textarea"
        rows="7"
        style="resize: none;"
        autocomplete="off"
    ></textarea>
</template>
