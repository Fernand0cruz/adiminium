<template>
    <label class="inline-block text-sm mt-2.5">{{ props.label }}</label>
</template>

<script setup>
const props = defineProps({
    label: String
});
</script>
