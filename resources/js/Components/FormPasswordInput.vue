<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input 
        class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="password" 
        v-model.number="model" 
        ref="input" 
        autocomplete="off" 
    />
</template>
