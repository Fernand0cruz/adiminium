<template>
    <div v-show="props.message">
        <p class="text-sm text-red-600">
            {{ props.message }}
        </p>
    </div>
</template>

<script setup>
const props = defineProps({
    message: String
});
</script>